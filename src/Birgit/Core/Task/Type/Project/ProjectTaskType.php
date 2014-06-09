<?php

namespace Birgit\Core\Task\Type\Project;

use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Core\Model\Project\Project;
use Birgit\Core\Task\Queue\Context\Project\ProjectTaskQueueContextInterface;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;
use Birgit\Core\Task\Type\TaskType;
use Birgit\Component\Task\Queue\Exception\SuspendTaskQueueException;

/**
 * Project Task type
 */
class ProjectTaskType extends TaskType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'project';
    }

    protected function runProjectStatus(Project $project, TaskQueueContextInterface $context)
    {
        $taskQueue = $context->getTaskManager()
            ->createProjectTaskQueue($project, [
                'project_status'
            ]);

        $context->getTaskQueue()
            ->addPredecessor($taskQueue);

        throw new SuspendTaskQueueException();
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

        // Get project handler
        $projectHandler = $this->projectManager
            ->handleProject($project, $context);

        $projectHandler->onProjectTask($task);




        return;
        die;




        

        if ($task->isFirstAttempt() || !$project->getStatus()->isUp()) {
            $this->runProjectStatus(
                $project,
                $context
            );
        }

        // Get "real life" project references
        $projectHandlerReferences = $projectHandler
            ->getReferences();

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

                $taskQueue = $context->getTaskManager()
                    ->createProjectTaskQueue($project, [
                        'project_reference_delete' => [
                            'project_reference_name' => $projectReference->getName()
                        ]
                    ]);

                $context->getTaskQueue()
                    ->addSuccessor($taskQueue);
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

            $taskQueue = $context->getTaskManager()
                ->createProjectReferenceTaskQueue($projectReference, [
                    'project_reference'
                ]);

            $context->getTaskQueue()
                ->addSuccessor($taskQueue);
        }
    }
}
