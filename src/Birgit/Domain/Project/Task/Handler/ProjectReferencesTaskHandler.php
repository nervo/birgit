<?php

namespace Birgit\Domain\Project\Task\Handler;

use Birgit\Domain\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Domain\Project\ProjectEvents;
use Birgit\Domain\Project\Event\ProjectStatusEvent;
use Birgit\Model\Task\Task;
use Birgit\Model\Project\ProjectStatus;
use Birgit\Component\Parameters\Parameters;
use Birgit\Domain\Handler\HandlerDefinition;
use Birgit\Domain\Project\Task\Queue\Context\ProjectTaskQueueContextInterface;
use Birgit\Domain\Exception\Context\ContextException;
use Birgit\Domain\Project\Event\ProjectReferenceEvent;

/**
 * Project References Task handler
 */
class ProjectReferencesTaskHandler extends ProjectTaskHandler
{
    public function getType()
    {
        return 'project_references';
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

                // Delete
                // ...
                
                // Dispatch event
                $context->getEventDispatcher()
                    ->dispatch(
                        ProjectEvents::REFERENCE_DELETE,
                        new ProjectReferenceEvent($projectReference)
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

            if ($projectReferenceFound) {
                // Dispatch event
                $context->getEventDispatcher()
                    ->dispatch(
                        ProjectEvents::REFERENCE,
                        new ProjectReferenceEvent($projectReference)
                    );
                /*
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
                */
            } else {
                // Dispatch event
                $context->getEventDispatcher()
                    ->dispatch(
                        ProjectEvents::REFERENCE_CREATE,
                        new ProjectReferenceEvent($projectReference)
                    );
                /*
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
                */
            }
        }
    }
}
