<?php

namespace Birgit\Domain\Task\Handler\Project;

use Birgit\Component\Task\Model\Task\Task;
use Birgit\Model\Project\ProjectStatus;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Domain\Task\Queue\Context\ProjectTaskQueueContextInterface;
use Birgit\Domain\Project\ProjectEvents;
use Birgit\Domain\Project\Event\ProjectEvent;
use Birgit\Component\Context\Exception\ContextException;
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
            throw new ContextException();
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
