<?php

namespace Birgit\Domain\Project\Task\Handler;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Task\Handler\TaskHandler;
use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Domain\Handler\HandlerManager;
use Birgit\Model\Task\Task;
use Birgit\Model\ModelManagerInterface;
use Birgit\Component\Parameters\Parameters;
use Birgit\Domain\Handler\HandlerDefinition;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContextInterface;

/**
 * Project reference Task handler
 */
class ProjectReferenceTaskHandler extends TaskHandler
{
    protected $handlerManager;
    protected $modelManager;
    protected $eventDispatcher;

    public function __construct(
        HandlerManager $handlerManager,
        ModelManagerInterface $modelManager,
        EventDispatcherInterface $eventDispatcher)
    {
        $this->handlerManager  = $handlerManager;
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
        $projectHandler = $this->handlerManager
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
                    new HandlerDefinition(
                        'project_reference_revision',
                        new Parameters(array(
                            'project_name'                    => $projectReference->getProject()->getName(),
                            'project_reference_name'          => $projectReference->getName(),
                            'project_reference_revision_name' => $projectHandlerReferenceRevisionName
                        ))
                    )
                );

            $this->handlerManager
                ->getTaskQueueHandler($taskQueue)
                    ->run($taskQueue);
        } else {
            // Log
            $context->getLogger()->info(sprintf('New Project "%s" reference "%s" revision "%s"', $projectReference->getProject()->getName(), $projectReference->getName(), $projectHandlerReferenceRevisionName));

            $taskQueue = $this->modelManager
                ->getTaskQueueRepository()
                ->create(
                    new HandlerDefinition(
                        'project_reference_revision_create',
                        new Parameters(array(
                            'project_name'                    => $projectReference->getProject()->getName(),
                            'project_reference_name'          => $projectReference->getName(),
                            'project_reference_revision_name' => $projectHandlerReferenceRevisionName
                        ))
                    )
                );

            $this->handlerManager
                ->getTaskQueueHandler($taskQueue)
                    ->run($taskQueue);
        }
    }
}
