<?php

namespace Birgit\Core\Task\Queue\Handler;

use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Core\Task\Queue\Context\ProjectReferenceTaskQueueContext;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

/**
 * Project reference Task queue Handler
 */
class ProjectReferenceTaskQueueHandler extends TaskQueueHandler
{
    public function getType()
    {
        return 'project_reference';
    }

    public function run(TaskQueue $taskQueue, TaskQueueContextInterface $context)
    {
        // Get project
        $project = $this->modelManager
            ->getProjectRepository()
            ->get(
                $taskQueue->getTypeDefinition()->getParameter('project_name')
            );

        // Get project reference
        $projectReference = $this->modelManager
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
