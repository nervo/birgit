<?php

namespace Birgit\Core\Task\Type\Project;

use Birgit\Component\Task\Model\Task\Task;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Core\Task\Queue\Context\Project\ProjectTaskQueueContextInterface;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;
use Birgit\Core\Task\Type\TaskType;

/**
 * Project - References Task type
 */
class ProjectReferencesTaskType extends TaskType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'project_references';
    }

    /**
     * {@inheritdoc}
     */
    public function run(Task $task, TaskQueueContextInterface $context)
    {
        if (!$context instanceof ProjectTaskQueueContextInterface) {
            throw new ContextTaskQueueException();
        }

        // Get project
        $project = $context->getProject();

        // Get handler project references
        $projectHandlerReferences = $this->projectManager
            ->handleProject($project)
            ->getReferences($context);

        // Find project references to delete
        foreach ($project->getReferences() as $projectReference) {
            $projectReferenceFound = false;
            foreach ($projectHandlerReferences as $projectHandlerReferenceName => $projectHandlerReferenceRevisionName) {
                if ($projectReference->getName() === $projectHandlerReferenceName) {
                    $projectReferenceFound = true;
                    break;
                }
            }

            // Delete project reference
            if (!$projectReferenceFound) {

                // Push reference delete task as successor
                $context->getTaskManager()
                    ->handleTaskQueue($context->getTaskQueue())
                    ->pushSuccessor(
                        $context->getTaskManager()
                            ->createProjectTaskQueue($project, [
                                'project_reference_delete' => [
                                    'project_reference_name' => $projectReference->getName()
                                ]
                            ])
                    );
            }
        }

        // Find project references
        foreach ($projectHandlerReferences as $projectHandlerReferenceName => $projectHandlerReferenceRevisionName) {
            $projectReferenceFound = false;
            foreach ($project->getReferences() as $projectReference) {
                if ($projectReference->getName() === $projectHandlerReferenceName) {
                    $projectReferenceFound = true;
                    break;
                }
            }

            if (!$projectReferenceFound) {
                // Get project reference repository
                $projectReferenceRepository =  $this->modelRepositoryManager
                    ->getProjectReferenceRepository();

                // Create
                $projectReference = $projectReferenceRepository
                    ->create(
                        $projectHandlerReferenceName,
                        $project
                    );

                // Save
                $projectReferenceRepository->save($projectReference);
            }

            // Push reference task as successor
            $context->getTaskManager()
                ->handleTaskQueue($context->getTaskQueue())
                ->pushSuccessor(
                    $context->getTaskManager()
                        ->createProjectReferenceTaskQueue($projectReference, [
                            'project_reference'
                        ])
                );
        }
    }
}
