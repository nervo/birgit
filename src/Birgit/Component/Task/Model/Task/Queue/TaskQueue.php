<?php

namespace Birgit\Component\Task\Model\Task\Queue;

use Birgit\Component\Type\Typeable;
use Birgit\Component\Task\Model\Task\Task;

/**
 * Task queue
 */
abstract class TaskQueue implements Typeable
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
     * Add predecessor
     *
     * @param TaskQueue $predecessor
     *
     * @return TaskQueue
     */
    abstract public function addPredecessor(TaskQueue $predecessor);

    /**
     * Remove predecessor
     *
     * @param TaskQueue $predecessor
     *
     * @return TaskQueue
     */
    abstract public function removePredecessor(TaskQueue $predecessor);

    /**
     * Get predecessors
     *
     * @return \Traversable
     */
    abstract public function getPredecessors();

    /**
     * Has predecessors
     *
     * @return bool
     */
    public function hasPredecessors()
    {
        return (bool) count($this->getPredecessors());
    }

    /**
     * Get head
     *
     * @return TaskQueue|null
     */
    abstract public function getHead();

    /**
     * Has head
     *
     * @return bool
     */
    public function hasHead()
    {
        return (bool) $this->getHead();
    }

    /**
     * Add successor
     *
     * @param TaskQueue $successor
     *
     * @return TaskQueue
     */
    abstract public function addSuccessor(TaskQueue $successor);

    /**
     * Remove successor
     *
     * @param TaskQueue $successor
     *
     * @return TaskQueue
     */
    abstract public function removeSuccessor(TaskQueue $successor);

    /**
     * Get successors
     *
     * @return \Traversable
     */
    abstract public function getSuccessors();

    /**
     * Has successors
     *
     * @return bool
     */
    public function hasSuccessors()
    {
        return (bool) count($this->getSuccessors());
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getId();
    }
}
