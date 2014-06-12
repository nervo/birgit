<?php

namespace Birgit\Core\Task\Type\Project\Reference;

use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Core\Task\Queue\Context\Project\Reference\ProjectReferenceTaskQueueContextInterface;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;
use Birgit\Core\Task\Type\TaskType;

/**
 * Project Reference - Revisions Task type
 */
class ProjectReferenceRevisionsTaskType extends TaskType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'project_reference_revisions';
    }

    /**
     * {@inheritdoc}
     */
    public function run(Task $task, TaskQueueContextInterface $context)
    {
        if (!$context instanceof ProjectReferenceTaskQueueContextInterface) {
            throw new ContextTaskQueueException();
        }

        // Get project reference
        $projectReference = $context->getProjectReference();

        // Get project handler reference revision
        $projectHandlerReferenceRevisionName = $this->projectManager
            ->handleProject($projectReference->getProject())
            ->getReferenceRevision(
                $projectReference,
                $context
            );

        // Find project reference revisions
        $projectReferenceRevisionFound = false;
        foreach ($projectReference->getRevisions() as $projectReferenceRevision) {
            if ($projectReferenceRevision->getName() === $projectHandlerReferenceRevisionName) {
                $projectReferenceRevisionFound = true;
                break;
            }
        }

        if (!$projectReferenceRevisionFound) {
            // Get project reference revision repository
            $projectReferenceRevisionRepository =  $this->modelRepositoryManager
                ->getProjectReferenceRevisionRepository();

            // Create
            $projectReferenceRevision = $projectReferenceRevisionRepository
                ->create(
                    $projectHandlerReferenceRevisionName,
                    $projectReference
                );

            // Save
            $projectReferenceRevisionRepository->save($projectReferenceRevision);
        }

        // Push reference revision task as successor
        $context->getTaskManager()
            ->handleTaskQueue($context->getTaskQueue())
            ->pushSuccessor(
                $context->getTaskManager()
                    ->createProjectReferenceRevisionTaskQueue($projectReferenceRevision, [
                        'project_reference_revision'
                    ])
            );
    }
}
