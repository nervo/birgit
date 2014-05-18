<?php


namespace Birgit\Domain\Project\Task\Queue\Handler;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Project\ProjectManager;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContext;
use Birgit\Domain\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Domain\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Domain\Task\TaskManager;
use Birgit\Model\Task\Queue\TaskQueue;

class ProjectReferenceDeleteTaskQueueHandler extends TaskQueueHandler
{
    protected $projectManager;

    public function __construct(ProjectManager $projectManager, TaskManager $taskManager, EventDispatcherInterface $eventDispatcher, LoggerInterface $logger)
    {
        $this->projectManager = $projectManager;
        
        parent::__construct($taskManager, $eventDispatcher, $logger);
    }
    
    public function getType()
    {
        return 'project_reference_create';
    }
    
    protected function preRun(TaskQueue $taskQueue)
    {
        // Get project name
        $projectName = $taskQueue->getParameters()->get('project_name');
        
        // Get project
        $project = $this->projectManager
            ->findProject($projectName);

        $projectReference = $this->projectManager
            ->findProjectReference(
                $project,
                $taskQueue->getParameters()->get('project_reference_name')
            );

        return new ProjectReferenceTaskQueueContext(
            $projectReference,
            $taskQueue,
            $this->logger
        );
    }
    
    protected function postRun(TaskQueueContextInterface $context)
    {
        $this->projectManager
            ->deleteProjectReference(
                $context->getProjectReference()
            );
    }
}
