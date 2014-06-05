<?php

namespace Birgit\Core\Task\Queue\Type\Project;

use Birgit\Core\Task\Queue\Type\TaskQueueType;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Core\Task\Queue\Context\Project\ProjectTaskQueueContext;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

/**
 * Project Task queue Type
 */
class ProjectTaskQueueType extends TaskQueueType
{
    public function getAlias()
    {
        return 'project';
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
                $context
            )
        );
    }
}
