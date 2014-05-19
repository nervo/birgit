<?php

namespace Birgit\Domain\Project\Task\Handler;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Task\Handler\TaskHandler;
use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Domain\Project\ProjectManager;
use Birgit\Model\Task\Task;
use Birgit\Component\Parameters\Parameters;
use Birgit\Domain\Task\TaskManager;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContextInterface;

/**
 * Project reference Check Task handler
 */
class ProjectReferenceCheckTaskHandler extends TaskHandler
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
        return 'project_reference_check';
    }

    public function run(Task $task, TaskQueueContext $context)
    {
        if (!$context instanceof ProjectReferenceTaskQueueContextInterface) {
            return;
        }
        
        // Get project reference
        $projectReference = $context->getProjectReference();

        // Log
        $context->getLogger()->notice(sprintf('Task Handler: Project Reference Check "%s" "%s"', $projectReference->getProject()->getName(), $projectReference->getName()));
        
        // Get project handler
        $projectHandler = $this->projectManager
            ->getProjectHandler(
                $projectReference->getProject()
            );

        // Get "real life" project reference revision
        $projectHandlerReferenceRevisionName = $projectHandler->getReferenceRevision(
            $projectReference,
            $context
        );

        // Find created project reference revision
        $projectReferenceRevisionFound = false;
        foreach ($projectReference->getRevisions() as $projectReferenceRevision) {
            if ($projectReferenceRevision->getName() === $projectHandlerReferenceRevisionName) {
                $projectReferenceRevisionFound = true;
                break;
            }
        }

        if (!$projectReferenceRevisionFound) {
            // Log
            $context->getLogger()->info(sprintf('New Project "%s" reference "%s" revision "%s"', $projectReference->getProject()->getName(), $projectReference->getName(), $projectHandlerReferenceRevisionName));

            $taskQueue = $this->taskManager
                ->createTaskQueue(
                    'project_reference_revision_create',
                    new Parameters(array(
                        'project_name'                    => $projectReference->getProject()->getName(),
                        'project_reference_name'          => $projectReference->getName(),
                        'project_reference_revision_name' => $projectHandlerReferenceRevisionName
                    ))
                );

            $this->taskManager
                ->getTaskQueueHandler($taskQueue)
                    ->run($taskQueue);
        }
    }
}
