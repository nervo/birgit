<?php

namespace Birgit\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Task compiler pass
 */
class TaskCompilerPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $managerDefinition = $container->getDefinition('birgit.task_manager');

        $typeServices = $container->findTaggedServiceIds('birgit.task');

	foreach ($typeServices as $typeServiceId => $typeServiceTagAttributes) {
            foreach ($typeServiceTagAttributes as $typeServiceAttributes) {
                $managerDefinition->addMethodCall(
                    'addTaskType',
                    array($typeServiceAttributes['type'], new Reference($typeServiceId))
                );
            }
        }
    }
}
