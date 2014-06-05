<?php

namespace Birgit\Component\Task\Queue\Context;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Component\Task\TaskManager;

/**
 * Task queue Context
 */
class TaskQueueContext implements TaskQueueContextInterface
{
    protected $taskQueue;
    protected $taskManager;
    protected $eventDispatcher;
    protected $logger;

    public function __construct(
        TaskQueue $taskQueue,
        TaskManager $taskManager,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->taskQueue = $taskQueue;
        $this->taskManager = $taskManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
    }

    public function getTaskQueue()
    {
        return $this->taskQueue;
    }

    public function getTaskManager()
    {
        return $this->taskManager;
    }

    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    public function getLogger()
    {
        return $this->logger;
    }
}
