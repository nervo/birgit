<?php

namespace Birgit\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Repository compiler pass
 */
class RepositoryCompilerPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $managerDefinition = $container->getDefinition('birgit.repository_manager');

        $typeServices = $container->findTaggedServiceIds('birgit.repository');

	foreach ($typeServices as $typeServiceId => $typeServiceTagAttributes) {
            foreach ($typeServiceTagAttributes as $typeServiceAttributes) {
                $managerDefinition->addMethodCall(
                    'addRepositoryType',
                    array($typeServiceAttributes['type'], new Reference($typeServiceId))
                );
            }
        }
    }
}
