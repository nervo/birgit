<?php

namespace Birgit\Domain\Project\Task\Queue\Handler;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceRevisionTaskQueueContext;
use Birgit\Model\ModelManagerInterface;
use Birgit\Domain\Handler\HandlerManager;
use Birgit\Model\Task\Queue\TaskQueue;

class ProjectReferenceRevisionTaskQueueHandler extends TaskQueueHandler
{
    protected $modelManager;

    public function __construct(
        HandlerManager $handlerManager,
        ModelManagerInterface $modelManager,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->modelManager = $modelManager;

        parent::__construct($handlerManager, $eventDispatcher, $logger);
    }

    public function getType()
    {
        return 'project_reference_revision';
    }

    protected function preRun(TaskQueue $taskQueue)
    {
        // Get project
        $project = $this->modelManager
            ->getProjectRepository()
            ->get(
                $taskQueue->getHandlerDefinition()->getParameters()->get('project_name')
            );

        // Get project reference
        $projectReference = $this->modelManager
            ->getProjectReferenceRepository()
            ->get(
                $taskQueue->getHandlerDefinition()->getParameters()->get('project_reference_name'),
                $project
            );

        // Get project reference revision
        $projectReferenceRevision = $this->modelManager
            ->getProjectReferenceRevisionRepository()
            ->get(
                $taskQueue->getHandlerDefinition()->getParameters()->get('project_reference_revision_name'),
                $projectReference
            );

        return new ProjectReferenceRevisionTaskQueueContext(
            $projectReferenceRevision,
            $taskQueue,
            $this->logger
        );
    }
}
