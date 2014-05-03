<?php

namespace Birgit\Model;


abstract class Type implements TypeInterface
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
     * @var array
     */
    protected $parameters;

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Type
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
     * @param array $parameters
     *
     * @return Type
     */
    public function setParameters(array $parameters)
    {
        $this->parameters = $parameters;

        return $this;
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
}
