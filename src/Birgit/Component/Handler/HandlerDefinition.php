<?php

namespace Birgit\Component\Handler;

use Birgit\Component\Parameters\Parameters;

/**
 * Handler Definition
 */
class HandlerDefinition
{
    /**
     * Type
     *
     * @var string
     */
    protected $type;

    /**
     * Parameters
     *
     * @var Parameters
     */
    protected $parameters;

    /**
     * Constructor
     *
     * @param string     $type
     * @param Parameters $parameters
     */
    public function __construct($type, Parameters $parameters = null)
    {
        // Type
        $this->type = (string) $type;

        // Parameters
        $this->parameters = $parameters ? $parameters : new Parameters();
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get parameters
     *
     * @return Parameters
     */
    public function getParameters()
    {
        return $this->parameters;
    }
}
