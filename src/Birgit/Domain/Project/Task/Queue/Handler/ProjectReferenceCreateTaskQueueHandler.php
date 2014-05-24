<?php

namespace Birgit\Domain\Project\Task\Queue\Handler;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContext;
use Birgit\Model\ModelManagerInterface;
use Birgit\Domain\Handler\HandlerManager;
use Birgit\Model\Task\Queue\TaskQueue;

class ProjectReferenceCreateTaskQueueHandler extends TaskQueueHandler
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
        return 'project_reference_create';
    }

    protected function preRun(TaskQueue $taskQueue)
    {
        // Get project
        $project = $this->modelManager
            ->getProjectRepository()
            ->get(
                $taskQueue->getHandlerDefinition()->getParameters()->get('project_name')
            );

        // Create project reference
        $projectReference = $this->modelManager
            ->getProjectReferenceRepository()
            ->create(
                $taskQueue->getHandlerDefinition()->getParameters()->get('project_reference_name'),
                $project
            );

        // Save project reference
        $this->modelManager
            ->getProjectReferenceRepository()
            ->save($projectReference);

        return new ProjectReferenceTaskQueueContext(
            $projectReference,
            $taskQueue,
            $this->logger
        );
    }
}
