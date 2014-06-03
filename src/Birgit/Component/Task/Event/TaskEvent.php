<?php

namespace Birgit\Component\Task\Event;

use Symfony\Component\EventDispatcher\Event;

use Birgit\Component\Task\Model\Task\Task;

/**
 * Task Event
 */
class TaskEvent extends Event
{
    /**
     * Task
     *
     * @var Task
     */
    protected $task;

    /**
     * Constructor
     *
     * @param Task $task
     */
    public function __construct(Task $task)
    {
        // Task
        $this->task = $task;
    }

    /**
     * Get task
     *
     * @return Task
     */
    public function getTask()
    {
        return $this->task;
    }
}
