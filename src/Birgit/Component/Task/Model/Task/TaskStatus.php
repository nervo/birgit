<?php

namespace Birgit\Component\Task\Model\Task;

/**
 * Task Status
 */
class TaskStatus
{
    const PENDING  = 0;
    const RUNNING  = 1;
    const FINISHED = 2;

    /**
     * Value
     *
     * @var int
     */
    protected $value;

    /**
     * Constructor
     */
    public function __construct($value)
    {
        // Value
        $this->value = (int) $value;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function get()
    {
        return $this->value;
    }

    /**
     * Is value ?
     *
     * @param int $value
     *
     * @return bool
     */
    public function is($value)
    {
        return $this->value === (int) $value;
    }

    /**
     * Is pending ?
     *
     * @return bool
     */
    public function isPending()
    {
        return $this->is(self::PENDING);
    }
}
