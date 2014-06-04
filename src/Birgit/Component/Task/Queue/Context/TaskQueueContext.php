<?php

namespace Birgit\Component\Task\Queue\Context;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

/**
 * Task queue Context
 */
class TaskQueueContext implements TaskQueueContextInterface
{
    protected $taskQueue;
    protected $eventDispatcher;
    protected $logger;

    public function __construct(
        TaskQueue $taskQueue,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->taskQueue = $taskQueue;
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
    }

    public function getTaskQueue()
    {
        return $this->taskQueue;
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
