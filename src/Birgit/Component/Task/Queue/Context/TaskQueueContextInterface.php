<?php

namespace Birgit\Component\Task\Queue\Context;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Component\Task\TaskManager;

/**
 * Task queue Context Interface
 */
interface TaskQueueContextInterface
{
    /**
     * Get task queue
     *
     * @return TaskQueue
     */
    public function getTaskQueue();

    /**
     * Get task manager
     *
     * @return TaskManager
     */
    public function getTaskManager();

    /**
     * Get event dispatcher
     *
     * @return EventDispatcherInterface
     */
    public function getEventDispatcher();

    /**
     * Get logger
     *
     * @return LoggerInterface
     */
    public function getLogger();
}
