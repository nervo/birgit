<?php

namespace Birgit\Domain\Host\Task\Queue\Handler;

use Birgit\Domain\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Domain\Context\ContextInterface;
use Birgit\Domain\Host\Task\Queue\Context\HostTaskQueueContext;
use Birgit\Model\ModelManagerInterface;
use Birgit\Domain\Handler\HandlerManager;
use Birgit\Model\Task\Queue\TaskQueue;

class HostTaskQueueHandler extends TaskQueueHandler
{
    protected $modelManager;

    public function __construct(
        ModelManagerInterface $modelManager,
        HandlerManager $handlerManager
    ) {
        $this->modelManager = $modelManager;

        parent::__construct($handlerManager);
    }

    public function getType()
    {
        return 'host';
    }

    protected function preRun(TaskQueue $taskQueue, ContextInterface $context)
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

        // Get host
        $host = $this->modelManager
            ->getHostRepository()
            ->get(
                $projectReference,
                $projectEnvironment
            );
        
        return new HostTaskQueueContext(
            $host,
            $taskQueue,
            $context
        );
    }
}
