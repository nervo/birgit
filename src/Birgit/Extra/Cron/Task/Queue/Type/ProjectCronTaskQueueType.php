<?php

namespace Birgit\Extra\Cron\Task\Queue\Type;

use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Core\Task\Queue\Context\Project\ProjectTaskQueueContext;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

/**
 * Project Cron Task queue Type
 */
class ProjectCronTaskQueueType extends CronTaskQueueType
{
    public function getAlias()
    {
        return 'project_cron';
    }

    public function run(TaskQueue $taskQueue, TaskQueueContextInterface $context)
    {
        // Get project
        $project = $this->modelRepositoryManager
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
