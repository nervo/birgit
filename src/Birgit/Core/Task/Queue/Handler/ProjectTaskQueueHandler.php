<?php

namespace Birgit\Core\Task\Queue\Handler;

use Birgit\Component\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Core\Task\Queue\Context\ProjectTaskQueueContext;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

/**
 * Project Task queue Handler
 */
class ProjectTaskQueueHandler extends TaskQueueHandler
{
    public function getType()
    {
        return 'project';
    }

    public function run(TaskQueue $taskQueue, TaskQueueContextInterface $context)
    {
        // Get project
        $project = $this->modelManager
            ->getProjectRepository()
            ->get(
                $taskQueue->getTypeDefinition()->getParameter('project_name')
            );

        parent::run(
            $taskQueue,
            new ProjectTaskQueueContext(
                $project,
                $taskQueue,
                $context
            )
        );
    }
}
