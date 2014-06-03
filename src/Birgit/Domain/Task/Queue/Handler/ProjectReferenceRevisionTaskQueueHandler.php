<?php

namespace Birgit\Domain\Task\Queue\Handler;

use Birgit\Component\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Component\Context\ContextInterface;
use Birgit\Domain\Task\Queue\Context\ProjectReferenceRevisionTaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;

class ProjectReferenceRevisionTaskQueueHandler extends TaskQueueHandler
{
    public function getType()
    {
        return 'project_reference_revision';
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

        // Get project reference revision
        $projectReferenceRevision = $this->modelManager
            ->getProjectReferenceRevisionRepository()
            ->get(
                $taskQueue->getHandlerDefinition()->getParameters()->get('project_reference_revision_name'),
                $projectReference
            );

        parent::run(
            $taskQueue,
            new ProjectReferenceRevisionTaskQueueContext(
                $projectReferenceRevision,
                $taskQueue,
                $context
            )
        );
    }
}
