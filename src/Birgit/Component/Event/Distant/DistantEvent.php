<?php

namespace Birgit\Component\Event\Distant;

use Symfony\Component\EventDispatcher\Event;

/**
 * Distant Event
 */
class DistantEvent extends Event
{
    /**
     * Parameters
     *
     * @var array
     */
    protected $parameters = array();

    /**
     * Constructor
     * 
     * @param array $parameters
     */
    public function __construct(array $parameters = array())
    {
        // Parameters
        $this->parameters = $parameters;
    }

    /**
     * Get parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Get parameter value
     *
     * @param string $name
     * @param mixed  $default
     *
     * @return mixed
     */
    public function getParameter($name, $default = null)
    {
        if (array_key_exists((string) $name, $this->parameters)) {
            return $this->parameters[(string) $name];
        }

        return $default;
    }
}
