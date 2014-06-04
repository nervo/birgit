<?php

namespace Birgit\Component\Type\Bundle\Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Type Resolver Compiler Pass
 */
class TypeResolverCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $typeResolverIds = $container->findTaggedServiceIds('birgit.type_resolver');

        foreach ($typeResolverIds as $typeResolverId => $typeResolverAttributes) {
            foreach ($typeResolverAttributes as $typeResolverAttribute) {

                $typeIds = $container->findTaggedServiceIds($typeResolverAttribute['type']);

                foreach ($typeIds as $typeId => $typeAttributes) {
                    $container->getDefinition($typeResolverId)
                        ->addMethodCall(
                            'addType',
                            array(new Reference($typeId))
                        );
                }
            }
        }
    }
}
