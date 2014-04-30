<?php

namespace Birgit\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Host provider compiler pass
 */
class HostProviderCompilerPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param ContainerBuilder $container
     */
	public function process(ContainerBuilder $container)
    {
        $managerDefinition = $container->getDefinition('birgit.host_provider_manager');

        $typeServices = $container->findTaggedServiceIds('birgit.host_provider');

		foreach ($typeServices as $typeServiceId => $typeServiceTagAttributes) {
            foreach ($typeServiceTagAttributes as $typeServiceAttributes) {
                $managerDefinition->addMethodCall(
                    'addHostProvider',
                    array($typeServiceAttributes['type'], new Reference($typeServiceId))
                );
            }
        }
    }
}
