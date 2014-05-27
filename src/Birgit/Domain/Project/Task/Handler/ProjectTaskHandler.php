<?php

namespace Birgit\Domain\Project\Task\Handler;

use Birgit\Domain\Task\Handler\TaskHandler;
use Birgit\Domain\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Domain\Handler\HandlerManager;
use Birgit\Domain\Project\ProjectEvents;
use Birgit\Domain\Project\Event\ProjectStatusEvent;
use Birgit\Model\Task\Task;
use Birgit\Model\Project\ProjectStatus;
use Birgit\Component\Parameters\Parameters;
use Birgit\Domain\Handler\HandlerDefinition;
use Birgit\Model\ModelManagerInterface;
use Birgit\Domain\Project\Task\Queue\Context\ProjectTaskQueueContextInterface;
use Birgit\Domain\Exception\Context\ContextException;

/**
 * Project Task handler
 */
class ProjectTaskHandler extends TaskHandler
{
    protected $modelManager;
    protected $handlerManager;

    public function __construct(
        ModelManagerInterface $modelManager,
        HandlerManager $handlerManager
    ) {
        $this->modelManager   = $modelManager;
        $this->handlerManager = $handlerManager;
    }

    public function getType()
    {
        return 'project';
    }

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

        // Is project up ?
        $isUp = $projectHandler
            ->isUp($project, $context);

        // Compute status
        $status = $isUp ? ProjectStatus::UP : ProjectStatus::DOWN;

        if ($project->getStatus() != $status) {
            // Update project status
            $project->setStatus($status);

            $this->modelManager
                ->getProjectRepository()
                ->save($project);

            // Dispatch event
            $context->getEventDispatcher()
                ->dispatch(
                    ProjectEvents::PROJECT_STATUS,
                    new ProjectStatusEvent($project->getName(), $status)
                );
        }

        if (!$isUp) {
            return;
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

            if (!$projectReferenceFound) {

                $taskQueue =  $this->modelManager
                    ->getTaskQueueRepository()
                    ->create(
                        new HandlerDefinition(
                            'project_reference_delete',
                            new Parameters(array(
                                'project_name'           => $project->getName(),
                                'project_reference_name' => $projectHandlerReferenceName
                            ))
                        )
                    );

                $this->handlerManager
                    ->getTaskQueueHandler($taskQueue)
                        ->run($taskQueue);
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

            if ($projectReferenceFound) {
                $taskQueue =  $this->modelManager
                    ->getTaskQueueRepository()
                    ->create(
                        new HandlerDefinition(
                            'project_reference',
                            new Parameters(array(
                                'project_name'           => $project->getName(),
                                'project_reference_name' => $projectHandlerReferenceName
                            ))
                        )
                    );

                $this->handlerManager
                    ->getTaskQueueHandler($taskQueue)
                        ->run($taskQueue);
            } else {

                $taskQueue =  $this->modelManager
                    ->getTaskQueueRepository()
                    ->create(
                        new HandlerDefinition(
                            'project_reference_create',
                            new Parameters(array(
                                'project_name'           => $project->getName(),
                                'project_reference_name' => $projectHandlerReferenceName
                            ))
                        )
                    );

                $this->handlerManager
                    ->getTaskQueueHandler($taskQueue)
                        ->run($taskQueue);
            }
        }
    }
}
