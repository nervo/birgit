<?php

namespace Birgit\Domain\Task\Queue\Handler;

use Birgit\Component\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Component\Context\ContextInterface;
use Birgit\Domain\Task\Queue\Context\ProjectTaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;

/**
 * Project Task queue Handler
 */
class ProjectTaskQueueHandler extends TaskQueueHandler
{
    public function getType()
    {
        return 'project';
    }

    public function run(TaskQueue $taskQueue, ContextInterface $context)
    {
        // Get project
        $project = $this->modelManager
            ->getProjectRepository()
            ->get(
                $taskQueue->getHandlerDefinition()->getParameters()->get('project_name')
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
