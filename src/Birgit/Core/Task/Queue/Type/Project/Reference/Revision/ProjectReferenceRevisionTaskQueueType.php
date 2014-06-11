<?php

namespace Birgit\Core\Task\Queue\Type\Project\Reference\Revision;

use Birgit\Core\Task\Queue\Type\TaskQueueType;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Core\Task\Queue\Context\Project\Reference\Revision\ProjectReferenceRevisionTaskQueueContext;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

class ProjectReferenceRevisionTaskQueueType extends TaskQueueType
{
    public function getAlias()
    {
        return 'project_reference_revision';
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

        // Get project reference revision
        $projectReferenceRevision = $this->modelRepositoryManager
            ->getProjectReferenceRevisionRepository()
            ->get(
                $taskQueue->getTypeDefinition()->getParameter('project_reference_revision_name'),
                $projectReference
            );

        parent::run(
            $taskQueue,
            new ProjectReferenceRevisionTaskQueueContext(
                $projectReferenceRevision,
                $context
            )
        );
    }
}
