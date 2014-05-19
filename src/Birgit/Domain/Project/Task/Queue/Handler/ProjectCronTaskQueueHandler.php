<?php

namespace Birgit\Domain\Project\Task\Queue\Handler;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Cron\Task\Queue\Handler\CronTaskQueueHandler;
use Birgit\Domain\Project\Task\Queue\Context\ProjectTaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Domain\Project\ProjectManager;
use Birgit\Domain\Task\TaskManager;

/**
 * Project Cron Task queue Handler
 */
class ProjectCronTaskQueueHandler extends CronTaskQueueHandler
{
    protected $projectManager;

    public function __construct(ProjectManager $projectManager, TaskManager $taskManager, EventDispatcherInterface $eventDispatcher, LoggerInterface $logger)
    {
        $this->projectManager = $projectManager;

        parent::__construct($taskManager, $eventDispatcher, $logger);
    }

    public function getType()
    {
        return 'project_cron';
    }
    
    protected function preRun(TaskQueue $taskQueue)
    {
        // Get project name
        $projectName = $taskQueue->getParameters()->get('project_name');

        // Get project
        $project = $this->projectManager
            ->findProject($projectName);

        return new ProjectTaskQueueContext(
            $project,
            $taskQueue,
            $this->logger
        );
    }
}
