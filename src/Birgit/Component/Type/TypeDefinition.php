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

    /**
     * Set parameter
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return TypeDefinition
     */
    public function setParameter($name, $value)
    {
        $this->parameters[(string) $name] = $value;

        return $this;
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

    /**
     * Normalize
     *
     * @return array
     */
    public function normalize()
    {
        return array(
            'alias'      => $this->getAlias(),
            'parameters' => $this->getParameters()
        );
    }
}
