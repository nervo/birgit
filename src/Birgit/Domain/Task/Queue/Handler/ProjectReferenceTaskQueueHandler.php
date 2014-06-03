<?php

namespace Birgit\Domain\Task\Queue\Handler;

use Birgit\Component\Context\ContextInterface;
use Birgit\Component\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Domain\Task\Queue\Context\ProjectReferenceTaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;

/**
 * Project reference Task queue Handler
 */
class ProjectReferenceTaskQueueHandler extends TaskQueueHandler
{
    public function getType()
    {
        return 'project_reference';
    }

    public function run(TaskQueue $taskQueue, ContextInterface $context)
    {
        // Get project
        $project = $this->modelManager
            ->getProjectRepository()
            ->get(
                $taskQueue->getHandlerDefinition()->getParameters()->get('project_name')
            );

        // Get project reference
        $projectReference = $this->modelManager
            ->getProjectReferenceRepository()
            ->get(
                $taskQueue->getHandlerDefinition()->getParameters()->get('project_reference_name'),
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
