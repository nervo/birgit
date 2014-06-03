<?php

namespace Birgit\Model\Task\Queue;

use Birgit\Component\Handler\Handleable;
use Birgit\Model\Task\Task;

/**
 * Task queue
 */
abstract class TaskQueue implements Handleable
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this
            ->setStatus(
                new TaskQueueStatus(TaskQueueStatus::PENDING)
            )
            ->setAttempts(0);
    }

    /**
     * Get id
     *
     * @return string
     */
    abstract public function getId();

    /**
     * Set status
     *
     * @param TaskQueueStatus
     *
     * @return TaskQueue
     */
    abstract public function setStatus(TaskQueueStatus $status);

    /**
     * Get status
     *
     * @return TaskQueueStatus
     */
    abstract public function getStatus();

    /**
     * Set attempts
     *
     * @param int $attempts
     *
     * @return TaskQueue
     */
    abstract public function setAttempts($attempts);

    /**
     * Get attempts
     *
     * @return int
     */
    abstract public function getAttempts();

    /**
     * Increment attempts
     *
     * @return Task
     */
    public function incrementAttempts()
    {
        $this->setAttempts(
            $this->getAttempts() + 1
        );
    }

    /**
     * Is first attempt ?
     *
     * @return bool
     */
    public function isFirstAttempt()
    {
        return $this->getAttempts() <= 1;
    }

    /**
     * Add task
     *
     * @param Task $task
     *
     * @return TaskQueue
     */
    abstract public function addTask(Task $task);

    /**
     * Remove task
     *
     * @param Task $task
     *
     * @return TaskQueue
     */
    abstract public function removeTask(Task $task);

    /**
     * Get tasks
     *
     * @return \Traversable
     */
    abstract public function getTasks();

    /**
     * Add child
     *
     * @param TaskQueue $child
     *
     * @return TaskQueue
     */
    abstract public function addChild(TaskQueue $child);

    /**
     * Remove child
     *
     * @param TaskQueue $child
     *
     * @return TaskQueue
     */
    abstract public function removeChild(TaskQueue $child);

    /**
     * Get children
     *
     * @return \Traversable
     */
    abstract public function getChildren();

    /**
     * Has children
     *
     * @return bool
     */
    public function hasChildren()
    {
        return (bool) count($this->getChildren());
    }
}
