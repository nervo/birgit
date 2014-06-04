<?php

namespace Birgit\Core\Model\Project;

/**
 * Project Status
 */
class ProjectStatus
{
    const DOWN    = -1;
    const UNKNOWN = 0;
    const UP      = 1;

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
     * Is up ?
     *
     * @return bool
     */
    public function isUp()
    {
        return $this->is(self::UP);
    }
}
