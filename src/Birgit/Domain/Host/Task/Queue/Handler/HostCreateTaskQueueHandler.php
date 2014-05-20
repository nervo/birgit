<?php

namespace Birgit\Domain\Host\Task\Queue\Handler;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Project\ProjectManager;
use Birgit\Domain\Host\Task\Queue\Context\HostTaskQueueContext;
use Birgit\Domain\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Domain\Task\TaskManager;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\Host\HostRepositoryInterface;

class HostCreateTaskQueueHandler extends TaskQueueHandler
{
    protected $projectManager;
    protected $hostRepository;

    public function __construct(ProjectManager $projectManager, HostRepositoryInterface $hostRepository, TaskManager $taskManager, EventDispatcherInterface $eventDispatcher, LoggerInterface $logger)
    {
        $this->projectManager = $projectManager;
        $this->hostRepository = $hostRepository;

        parent::__construct($taskManager, $eventDispatcher, $logger);
    }

    public function getType()
    {
        return 'host_create';
    }

    protected function preRun(TaskQueue $taskQueue)
    {
        // Get project name
        $projectName = $taskQueue->getParameters()->get('project_name');

        // Get project
        $project = $this->projectManager
            ->findProject($projectName);

        // Get project reference name
        $projectReferenceName = $taskQueue->getParameters()->get('project_reference_name');

        // Get project reference
        $projectReference = $this->projectManager
            ->findProjectReference($project, $projectReferenceName);
        
        // Get project environment name
        $projectEnvironmentName = $taskQueue->getParameters()->get('project_environment_name');

        // Get project environment
        $projectEnvironment = $this->projectManager
            ->findProjectEnvironment($project, $projectEnvironmentName);

        // Get host
        $host = $this->hostRepository
            ->create($projectReference, $projectEnvironment);
        
        $this->hostRepository->save($host);
        
        return new HostTaskQueueContext(
            $host,
            $taskQueue,
            $this->logger
        );
    }
}
