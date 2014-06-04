<?php

namespace Birgit\Component\Type;

/**
 * Type Definition
 */
class TypeDefinition
{
    /**
     * Alias
     *
     * @var string
     */
    protected $alias;

    /**
     * Parameters
     *
     * @var array
     */
    protected $parameters = array();

    /**
     * Constructor
     *
     * @param string $alias
     * @param array  $parameters
     */
    public function __construct($alias, array $parameters = array())
    {
        // Alias
        $this->alias = (string) $alias;

        // Parameters
        $this->parameters = $parameters;
    }

    /**
     * Get alias
     *
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
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
