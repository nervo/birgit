<?php

namespace Birgit\Core\Task\Queue\Type;

use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Queue\Type\TaskQueueType;
use Birgit\Core\Task\Queue\Context\ProjectReferenceTaskQueueContext;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

/**
 * Project reference Task queue Type
 */
class ProjectReferenceTaskQueueType extends TaskQueueType
{
    public function getAlias()
    {
        return 'project_reference';
    }

    public function run(TaskQueue $taskQueue, TaskQueueContextInterface $context)
    {
        // Get project
        $project = $this->modelRepositoryManager
            ->getProjectRepository()
            ->get(
                $taskQueue->getTypeDefinition()->getParameter('project_name')
            );

        // Get project reference
        $projectReference = $this->modelRepositoryManager
            ->getProjectReferenceRepository()
            ->get(
                $taskQueue->getTypeDefinition()->getParameter('project_reference_name'),
                $project
            );

        parent::run(
            $taskQueue,
            new ProjectReferenceTaskQueueContext(
                $projectReference,
                $taskQueue,
                $context
            )
        );
    }
}
