<?php

namespace Birgit\Core\Task\Queue\Handler\Cron;

use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Core\Task\Queue\Context\ProjectTaskQueueContext;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

/**
 * Project Cron Task queue Handler
 */
class ProjectCronTaskQueueHandler extends CronTaskQueueHandler
{
    public function getType()
    {
        return 'project_cron';
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
