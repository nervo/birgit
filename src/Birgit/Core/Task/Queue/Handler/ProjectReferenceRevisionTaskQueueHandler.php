<?php

namespace Birgit\Core\Task\Queue\Handler;

use Birgit\Component\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Core\Task\Queue\Context\ProjectReferenceRevisionTaskQueueContext;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

class ProjectReferenceRevisionTaskQueueHandler extends TaskQueueHandler
{
    public function getType()
    {
        return 'project_reference_revision';
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

        // Get project reference revision
        $projectReferenceRevision = $this->modelManager
            ->getProjectReferenceRevisionRepository()
            ->get(
                $taskQueue->getTypeDefinition()->getParameter('project_reference_revision_name'),
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
