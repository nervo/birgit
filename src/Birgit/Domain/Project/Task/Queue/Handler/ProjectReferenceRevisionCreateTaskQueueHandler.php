<?php

namespace Birgit\Domain\Project\Task\Queue\Handler;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceRevisionTaskQueueContext;
use Birgit\Domain\Handler\HandlerManager;
use Birgit\Model\ModelManagerInterface;
use Birgit\Model\Task\Queue\TaskQueue;

class ProjectReferenceRevisionCreateTaskQueueHandler extends TaskQueueHandler
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
        return 'project_reference_revision_create';
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

        // Create project reference revision
        $projectReferenceRevision = $this->modelManager
            ->getProjectReferenceRevisionRepository()
            ->create(
                $taskQueue->getHandlerDefinition()->getParameters()->get('project_reference_revision_name'),
                $projectReference
            );

        // Save project reference revision
        $this->modelManager
            ->getProjectReferenceRevisionRepository()
            ->save($projectReferenceRevision);

        return new ProjectReferenceRevisionTaskQueueContext(
            $projectReferenceRevision,
            $taskQueue,
            $this->logger
        );
    }
}
