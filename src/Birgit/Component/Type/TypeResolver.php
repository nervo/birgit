<?php

namespace Birgit\Component\Type;

/**
 * Type Resolver
 */
class TypeResolver
{
    /**
     * Types
     *
     * @var array
     */
    protected $types = array();

    /**
     * Add Type
     *
     * @param TypeInterface $type
     *
     * @return TypeResolver
     */
    public function addProjectHandler(TypeInterface $type)
    {
        $this->types[] = $type;

        return $this;
    }
}
