<?php

namespace Birgit\Domain\Host\Task\Queue\Handler;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Domain\Host\Task\Queue\Context\HostTaskQueueContext;
use Birgit\Model\ModelManagerInterface;
use Birgit\Domain\Handler\HandlerManager;
use Birgit\Model\Task\Queue\TaskQueue;

class HostCreateTaskQueueHandler extends TaskQueueHandler
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
        return 'host_create';
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

        // Get project environment
        $projectEnvironment = $this->modelManager
            ->getProjectEnvironmentRepository()
            ->get(
                $taskQueue->getHandlerDefinition()->getParameters()->get('project_environment_name'),
                $project
            );

        // Create host
        $host = $this->modelManager
            ->getHostRepository()
            ->create(
                $projectReference,
                $projectEnvironment
            );
        
        // Save host
        $this->modelManager
            ->getHostRepository()
            ->save($host);
        
        return new HostTaskQueueContext(
            $host,
            $taskQueue,
            $this->logger
        );
    }
}
