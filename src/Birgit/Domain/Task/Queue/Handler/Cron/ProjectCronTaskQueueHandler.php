<?php

namespace Birgit\Domain\Task\Queue\Handler\Cron;

use Birgit\Domain\Context\ContextInterface;
use Birgit\Domain\Task\Queue\Context\ProjectTaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;

/**
 * Project Cron Task queue Handler
 */
class ProjectCronTaskQueueHandler extends CronTaskQueueHandler
{
    public function getType()
    {
        return 'project_cron';
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
