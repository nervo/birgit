<?php

namespace Birgit\Component\Task\Model\Task;

use Birgit\Component\Type\Typeable;

/**
 * Task
 */
abstract class Task implements Typeable
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
