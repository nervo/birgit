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
    /**
     * Task queue
     * 
     * @var TaskQueue 
     */
    protected $taskQueue;

    /**
     * Task manager
     *
     * @var TaskManager
     */
    protected $taskManager;

    /**
     * Event dispatcher
     *
     * @var EventDispatcherInterface
     */
    protected $eventDispatcher;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor
     * 
     * @param TaskQueue                $taskQueue
     * @param TaskManager              $taskManager
     * @param EventDispatcherInterface $eventDispatcher
     * @param LoggerInterface          $logger
     */
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

    /**
     * {@inheritdoc}
     */
    public function getTaskQueue()
    {
        return $this->taskQueue;
    }

    /**
     * {@inheritdoc}
     */
    public function getTaskManager()
    {
        return $this->taskManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventDispatcher()
    {
        return $this->eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function getLogger()
    {
        return $this->logger;
    }
}
