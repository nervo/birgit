<?php

namespace Birgit\Bundle\DoctrineBundle\Entity;

use Birgit\Model\ModelHandlerDefinition;
use Birgit\Component\Parameters\Parameters;

class EntityHandlerDefinition extends ModelHandlerDefinition
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
     */
    public function __construct()
    {
        $this->parameters = new Parameters();
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return TypeModel
     */
    public function setType($type)
    {
        $this->type = (string) $type;

        return $this;
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
     * Set parameters
     *
     * @param Parameters $parameters
     *
     * @return TypeModel
     */
    public function setParameters(Parameters $parameters)
    {
        $this->parameters = $parameters;

        return $this;
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
