<?php

namespace Birgit\Domain\Task\Handler\Project;

use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Core\Model\Project\Project;
use Birgit\Domain\Task\Queue\Context\ProjectTaskQueueContextInterface;
use Birgit\Component\Context\Exception\ContextException;
use Birgit\Component\Task\Handler\TaskHandler;
use Birgit\Component\Task\Queue\Exception\SuspendTaskQueueException;

/**
 * Project Task handler
 */
class ProjectTaskHandler extends TaskHandler
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'project';
    }

    protected function runProjectStatus(Project $project, TaskQueue $taskQueue)
    {
        $taskQueueChild = $this->taskManager
            ->createProjectTaskQueue($project, [
                'project_status'
            ]);

        $taskQueue
            ->addChild($taskQueueChild);

        $this->taskManager->pushTaskQueue($taskQueueChild);

        throw new SuspendTaskQueueException();
    }

    /**
     * {@inheritdoc}
     */
    public function run(Task $task, TaskQueueContextInterface $context)
    {
        if (!$context instanceof ProjectTaskQueueContextInterface) {
            throw new ContextException();
        }

        // Get project
        $project = $context->getProject();

        // Get project handler
        $projectHandler = $this->handlerManager
            ->getProjectHandler($project);

        if ($task->isFirstAttempt() || !$project->getStatus()->isUp()) {
            $this->runProjectStatus(
                $project,
                $context->getTaskQueue()
            );
        }

        // Get "real life" project references
        $projectHandlerReferences = $projectHandler
            ->getReferences($project, $context);

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

                $taskQueue = $this->taskManager
                    ->createProjectTaskQueue($project, [
                        'project_reference_delete' => [
                            'project_reference_name' => $projectReference->getName()
                        ]
                    ]);

                $this->taskManager->pushTaskQueue($taskQueue);
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
                $projectReferenceRepository =  $this->modelManager
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

            $taskQueue = $this->taskManager
                ->createProjectReferenceTaskQueue($projectReference, [
                    'project_reference'
                ]);

            $this->taskManager->pushTaskQueue($taskQueue);
        }
    }
}
