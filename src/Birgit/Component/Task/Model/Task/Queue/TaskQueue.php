<?php

namespace Birgit\Component\Task\Model\Task\Queue;

use Birgit\Component\Type\Typeable;

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
     * @return TaskQueue
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
     * Has predecessors
     *
     * @return bool
     */
    public function hasPredecessors()
    {
        return (bool) count($this->getPredecessors());
    }

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
     * Has successors
     *
     * @return bool
     */
    public function hasSuccessors()
    {
        return (bool) count($this->getSuccessors());
    }

    /**
     * Normalize
     *
     * @return array
     */
    public function normalize()
    {
        return array(
            'id'       => $this->getId(),
            'attempts' => $this->getAttempts(),
            'status'   => $this->getStatus()->normalize(),
            'type'     => $this->getTypeDefinition()->normalize()
        );
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
