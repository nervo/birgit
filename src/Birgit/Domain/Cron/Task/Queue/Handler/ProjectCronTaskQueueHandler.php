<?php

namespace Birgit\Domain\Cron\Task\Queue\Handler;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Cron\Task\Queue\Handler\CronTaskQueueHandler;
use Birgit\Domain\Project\Task\Queue\Context\ProjectTaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\ModelManagerInterface;
use Birgit\Domain\Task\TaskManager;

/**
 * Project Cron Task queue Handler
 */
class ProjectCronTaskQueueHandler extends CronTaskQueueHandler
{
    protected $modelManager;

    public function __construct(
        TaskManager $taskManager,
        ModelManagerInterface $modelManager,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->modelManager = $modelManager;

        parent::__construct($taskManager, $eventDispatcher, $logger);
    }

    public function getType()
    {
        return 'project_cron';
    }

    protected function preRun(TaskQueue $taskQueue)
    {
        // Get project
        $project = $this->modelManager
            ->getProjectRepository()
            ->get(
                $taskQueue->getParameters()->get('project_name')
            );

        return new ProjectTaskQueueContext(
            $project,
            $taskQueue,
            $this->logger
        );
    }
}
