<?php

namespace Birgit\Component\Task\Model\Task;

use Birgit\Component\Handler\Handleable;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

/**
 * Task
 */
abstract class Task implements Handleable
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this
            ->setStatus(
                new TaskStatus(TaskStatus::PENDING)
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
     * @param TaskStatus
     *
     * @return Task
     */
    abstract public function setStatus(TaskStatus $status);

    /**
     * Get status
     *
     * @return TaskStatus
     */
    abstract public function getStatus();

    /**
     * Set attempts
     *
     * @param int $attempts
     *
     * @return Task
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
     * Get queue
     *
     * @return TaskQueue
     */
    abstract public function getQueue();
}
