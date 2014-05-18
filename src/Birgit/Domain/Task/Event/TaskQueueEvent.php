<?php

namespace Birgit\Domain\Task\Event;

use Symfony\Component\EventDispatcher\Event;

use Birgit\Model\Task\Queue\TaskQueue;

/**
 * Task Queue Event
 */
class TaskQueueEvent extends Event
{
    protected $taskQueue;

    public function __construct(TaskQueue $taskQueue)
    {
        $this->taskQueue = $taskQueue;
    }

    public function getTaskQueue()
    {
        return $this->taskQueue;
    }
}
