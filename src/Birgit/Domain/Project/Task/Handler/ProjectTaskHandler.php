<?php

namespace Birgit\Domain\Project\Task\Handler;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Task\Handler\TaskHandler;
use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Domain\Project\ProjectManager;
use Birgit\Domain\Project\ProjectEvents;
use Birgit\Domain\Project\Event\ProjectStatusEvent;
use Birgit\Model\Task\Task;
use Birgit\Model\Project\ProjectStatus;
use Birgit\Component\Parameters\Parameters;
use Birgit\Domain\Task\TaskManager;
use Birgit\Domain\Project\Task\Queue\Context\ProjectTaskQueueContextInterface;

/**
 * Project Task handler
 */
class ProjectTaskHandler extends TaskHandler
{
    protected $eventDispatcher;
    protected $projectManager;
    protected $taskManager;

    public function __construct(EventDispatcherInterface $eventDispatcher, ProjectManager $projectManager, TaskManager $taskManager)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->projectManager  = $projectManager;
        $this->taskManager     = $taskManager;
    }

    public function getType()
    {
        return 'project';
    }

    public function run(Task $task, TaskQueueContext $context)
    {
        if (!$context instanceof ProjectTaskQueueContextInterface) {
            return;
        }

        // Get project
        $project = $context->getProject();

        // Log
        $context->getLogger()->notice(sprintf('Task Handler: Project "%s"', $project->getName()));

        // Get project handler
        $projectHandler = $this->projectManager
            ->getProjectHandler($project);

        // Is project up ?
        $isUp = $projectHandler
            ->isUp($project, $context);

        // Compute status
        $status = $isUp ? ProjectStatus::UP : ProjectStatus::DOWN;

        if ($project->getStatus() != $status) {
            // Update project status
            $project->setStatus($status);

            $this->projectManager
                ->saveProject($project);

            // Dispatch event
            $this->eventDispatcher
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

        // Find deleted project references
        foreach ($project->getReferences() as $projectReference) {
            $projectReferenceFound = false;
            foreach ($projectHandlerReferences as $projectHandlerReferenceName => $projectHandlerReferenceRevisionName) {
                if ($projectReference->getName() === $projectHandlerReferenceName) {
                    $projectReferenceFound = true;
                    break;
                }
            }

            if (!$projectReferenceFound) {
                // Log
                $context->getLogger()->info(sprintf('Old Project "%s" reference "%s" revision "%s"', $project->getName(), $projectHandlerReferenceName, $projectHandlerReferenceRevisionName));

                $taskQueue = $this->taskManager
                    ->createTaskQueue(
                        'project_reference_delete',
                        new Parameters(array(
                            'project_name'           => $project->getName(),
                            'project_reference_name' => $projectHandlerReferenceName
                        ))
                    );

                $this->taskManager
                    ->getTaskQueueHandler($taskQueue)
                        ->run($taskQueue);
            }
        }

        // Find created project references
        foreach ($projectHandlerReferences as $projectHandlerReferenceName => $projectHandlerReferenceRevisionName) {
            $projectReferenceFound = false;
            foreach ($project->getReferences() as $projectReference) {
                if ($projectReference->getName() === $projectHandlerReferenceName) {
                    $projectReferenceFound = true;
                    break;
                }
            }

            if ($projectReferenceFound) {
                $taskQueue = $this->taskManager
                    ->createTaskQueue(
                        'project_reference',
                        new Parameters(array(
                            'project_name'           => $project->getName(),
                            'project_reference_name' => $projectHandlerReferenceName
                        ))
                    );

                $this->taskManager
                    ->getTaskQueueHandler($taskQueue)
                        ->run($taskQueue);
            } else {
                // Log
                $context->getLogger()->info(sprintf('New Project "%s" reference "%s" revision "%s"', $project->getName(), $projectHandlerReferenceName, $projectHandlerReferenceRevisionName));

                $taskQueue = $this->taskManager
                    ->createTaskQueue(
                        'project_reference_create',
                        new Parameters(array(
                            'project_name'           => $project->getName(),
                            'project_reference_name' => $projectHandlerReferenceName
                        ))
                    );

                $this->taskManager
                    ->getTaskQueueHandler($taskQueue)
                        ->run($taskQueue);
            }
        }
    }
}
