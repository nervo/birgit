<?php

namespace Birgit\Domain\Host\Task\Queue\Handler;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;


use Birgit\Domain\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Domain\Host\Task\Queue\Context\HostTaskQueueContext;
use Birgit\Model\Project\ProjectRepositoryInterface;
use Birgit\Model\Project\Reference\ProjectReferenceRepositoryInterface;
use Birgit\Model\Project\Environment\ProjectEnvironmentRepositoryInterface;
use Birgit\Domain\Task\TaskManager;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\Host\HostRepositoryInterface;

class HostTaskQueueHandler extends TaskQueueHandler
{
    protected $projectRepository;
    protected $projectReferenceRepository;
    protected $projectEnvironmentRepository;
    protected $hostRepository;

    public function __construct(
        ProjectRepositoryInterface $projectRepository,
        ProjectReferenceRepositoryInterface $projectReferenceRepository,
        ProjectEnvironmentRepositoryInterface $projectEnvironmentRepository,
        HostRepositoryInterface $hostRepository,
        TaskManager $taskManager,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->projectRepository = $projectRepository;
        $this->projectReferenceRepository = $projectReferenceRepository;
        $this->projectEnvironmentRepository = $projectEnvironmentRepository;
        $this->hostRepository = $hostRepository;

        parent::__construct($taskManager, $eventDispatcher, $logger);
    }

    public function getType()
    {
        return 'host';
    }

    protected function preRun(TaskQueue $taskQueue)
    {
        // Get project
        $project = $this->projectRepository
            ->get(
                $taskQueue->getParameters()->get('project_name')
            );

        // Get project reference
        $projectReference = $this->projectReferenceRepository
            ->get(
                $taskQueue->getParameters()->get('project_reference_name'),
                $project
            );

        // Get project environment
        $projectEnvironment = $this->projectEnvironmentRepository
            ->get(
                $taskQueue->getParameters()->get('project_environment_name'),
                $project
            );

        // Get host
        $host = $this->hostRepository
            ->get(
                $projectReference,
                $projectEnvironment
            );
        
        return new HostTaskQueueContext(
            $host,
            $taskQueue,
            $this->logger
        );
    }
}
