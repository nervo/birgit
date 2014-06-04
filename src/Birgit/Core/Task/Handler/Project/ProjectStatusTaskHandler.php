<?php

namespace Birgit\Core\Task\Handler\Project;

use Birgit\Component\Task\Model\Task\Task;
use Birgit\Core\Model\Project\ProjectStatus;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Core\Task\Queue\Context\ProjectTaskQueueContextInterface;
use Birgit\Core\Project\ProjectEvents;
use Birgit\Core\Project\Event\ProjectEvent;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;
use Birgit\Component\Task\Handler\TaskHandler;

/**
 * Project - Status Task handler
 */
class ProjectStatusTaskHandler extends TaskHandler
{
    /**
     * {@inheritdoc}
     */
    public function getType()
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
        $projectHandler = $this->handlerManager
            ->getProjectHandler($project);

        // Is project up ?
        $isUp = $projectHandler
            ->isUp($project, $context);

        // Compute status
        $status = $isUp ? ProjectStatus::UP : ProjectStatus::DOWN;

        // Update project status
        if (!$project->getStatus()->is($status)) {

            $project->setStatus(new ProjectStatus($status));

            $this->modelManager
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
