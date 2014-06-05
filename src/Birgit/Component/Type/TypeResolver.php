<?php

namespace Birgit\Component\Type;

use Birgit\Component\Type\Exception\NotFoundException;

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
    public function addType(TypeInterface $type)
    {
        $this->types[] = $type;

        return $this;
    }

    /**
     * Resolve typeable type
     *
     * @param Typeable $typeable
     *
     * @return Type
     *
     * @throws NotFoundException
     */
    public function resolve(Typeable $typeable)
    {
        $alias = $typeable->getTypeDefinition()->getAlias();

        foreach ($this->types as $type) {
            if ($type->getAlias() === $alias) {
                return $type;
            }
        }

        throw new NotFoundException(sprintf('Type "%s" not found', $alias));
    }
}
