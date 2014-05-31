<?php

namespace Birgit\Domain\Project\Task\Handler;

use Birgit\Domain\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Model\Task\Task;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\Project\Project;
use Birgit\Component\Parameters\Parameters;
use Birgit\Domain\Handler\HandlerDefinition;
use Birgit\Domain\Project\Task\Queue\Context\ProjectTaskQueueContextInterface;
use Birgit\Domain\Exception\Context\ContextException;
use Birgit\Domain\Task\Handler\TaskHandler;
use Birgit\Domain\Exception\Task\Queue\SuspendTaskQueueException;

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
        // Create task queue child
        $taskQueueChild = $this->modelManager
            ->getTaskQueueRepository()
            ->create(
                new HandlerDefinition(
                    'project',
                    new Parameters(array(
                        'project_name' => $project->getName()
                    ))
                )
            );

        // Add task
        $taskQueueChild
            ->addTask(
                $this->modelManager
                    ->getTaskRepository()
                    ->create(
                        new HandlerDefinition(
                            'project_status'
                        )
                    )
            );

        $taskQueue
            ->addChild($taskQueueChild);

        // Push
        $this->handlerManager
            ->getTaskQueueHandler($taskQueueChild)
                ->push($taskQueueChild);

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
                // Create task queue
                $taskQueue = $this->modelManager
                    ->getTaskQueueRepository()
                    ->create(
                        new HandlerDefinition(
                            'project',
                            new Parameters(array(
                                'project_name' => $project->getName(),

                            ))
                        )
                    );

                // Add task
                $taskQueue
                    ->addTask(
                        $this->modelManager
                            ->getTaskRepository()
                            ->create(
                                new HandlerDefinition(
                                    'project_reference_delete',
                                    new Parameters(array(
                                        'project_reference_name' => $projectReference->getName()
                                    ))
                                )
                            )
                    );

                // Push
                $this->handlerManager
                    ->getTaskQueueHandler($taskQueue)
                        ->push($taskQueue);
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

            $taskQueue =  $this->modelManager
                ->getTaskQueueRepository()
                ->create(
                    new HandlerDefinition(
                        'project_reference',
                        new Parameters(array(
                            'project_name'           => $project->getName(),
                            'project_reference_name' => $projectReference->getName()
                        ))
                    )
                );

            // Add task
            $taskQueue
                ->addTask(
                    $this->modelManager
                        ->getTaskRepository()
                        ->create(
                            new HandlerDefinition(
                                'project_reference'
                            )
                        )
                );

            // Push
            $this->handlerManager
                ->getTaskQueueHandler($taskQueue)
                    ->push($taskQueue);
        }
    }
}
