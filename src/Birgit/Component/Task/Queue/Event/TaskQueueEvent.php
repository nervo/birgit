<?php

namespace Birgit\Component\Task\Queue\Event;

use Symfony\Component\EventDispatcher\Event;

use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

/**
 * Task Queue Event
 */
class TaskQueueEvent extends Event
{
    /**
     * Task queue
     *
     * @var TaskQueue
     */
    protected $taskQueue;

    /**
     * Constructor
     *
     * @param TaskQueue $taskQueue
     */
    public function __construct(TaskQueue $taskQueue)
    {
        // Task queue
        $this->taskQueue = $taskQueue;
    }

    /**
     * Get task queue
     *
     * @return TaskQueue
     */
    public function getTaskQueue()
    {
        return $this->taskQueue;
    }
}
