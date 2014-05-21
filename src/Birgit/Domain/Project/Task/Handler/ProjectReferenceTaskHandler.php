<?php

namespace Birgit\Domain\Project\Task\Handler;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Task\Handler\TaskHandler;
use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Domain\Project\ProjectManager;
use Birgit\Model\Task\Task;
use Birgit\Model\ModelManagerInterface;
use Birgit\Component\Parameters\Parameters;
use Birgit\Domain\Task\TaskManager;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContextInterface;

/**
 * Project reference Task handler
 */
class ProjectReferenceTaskHandler extends TaskHandler
{
    protected $projectManager;
    protected $taskManager;
    protected $modelManager;
    protected $eventDispatcher;

    public function __construct(
        ProjectManager $projectManager,
        TaskManager $taskManager,
        ModelManagerInterface $modelManager,
        EventDispatcherInterface $eventDispatcher)
    {
        $this->projectManager  = $projectManager;
        $this->taskManager     = $taskManager;
        $this->modelManager    = $modelManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function getType()
    {
        return 'project_reference';
    }

    public function run(Task $task, TaskQueueContext $context)
    {
        if (!$context instanceof ProjectReferenceTaskQueueContextInterface) {
            return;
        }

        // Get project reference
        $projectReference = $context->getProjectReference();

        // Log
        $context->getLogger()->notice(sprintf('Task Handler: Project Reference "%s" "%s"', $projectReference->getProject()->getName(), $projectReference->getName()));

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

        // Find project reference revisions
        $projectReferenceRevisionFound = false;
        foreach ($projectReference->getRevisions() as $projectReferenceRevision) {
            if ($projectReferenceRevision->getName() === $projectHandlerReferenceRevisionName) {
                $projectReferenceRevisionFound = true;
                break;
            }
        }

        if ($projectReferenceRevisionFound) {
            $taskQueue = $this->modelManager
                ->getTaskQueueRepository()
                ->create(
                    'project_reference_revision',
                    new Parameters(array(
                        'project_name'                    => $projectReference->getProject()->getName(),
                        'project_reference_name'          => $projectReference->getName(),
                        'project_reference_revision_name' => $projectHandlerReferenceRevisionName
                    ))
                );

            $this->taskManager
                ->getTaskQueueHandler($taskQueue)
                    ->run($taskQueue);
        } else {
            // Log
            $context->getLogger()->info(sprintf('New Project "%s" reference "%s" revision "%s"', $projectReference->getProject()->getName(), $projectReference->getName(), $projectHandlerReferenceRevisionName));

            $taskQueue = $this->modelManager
                ->getTaskQueueRepository()
                ->create(
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
