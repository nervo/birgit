<?php

namespace Birgit\Core\Task\Type\Project;

use Birgit\Component\Task\Model\Task\Task;
use Birgit\Core\Model\Project\ProjectStatus;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Core\Task\Queue\Context\Project\ProjectTaskQueueContextInterface;
use Birgit\Core\Project\ProjectEvents;
use Birgit\Core\Project\Event\ProjectEvent;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;
use Birgit\Core\Task\Type\TaskType;

/**
 * Project - Status Task type
 */
class ProjectStatusTaskType extends TaskType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'project_status';
    }

    /**
     * {@inheritdoc}
     */
    public function run(Task $task, TaskQueueContextInterface $context)
    {
        if (!$context instanceof ProjectTaskQueueContextInterface) {
            throw new ContextTaskQueueException();
        }

        // Get project
        $project = $context->getProject();

        // Get project handler
        $projectHandler = $this->projectManager
            ->handleProject($project, $context);

        // Is project up ?
        $isUp = $projectHandler
            ->isUp($project, $context);

        // Compute status
        $status = $isUp ? ProjectStatus::UP : ProjectStatus::DOWN;

        // Update project status
        if (!$project->getStatus()->is($status)) {

            $project->setStatus(new ProjectStatus($status));

            $this->modelRepositoryManager
                ->getProjectRepository()
                ->save($project);

            // Dispatch event
            $context->getEventDispatcher()
                ->dispatch(
                    ProjectEvents::STATUS,
                    new ProjectEvent($project)
                );
        }
    }
}
