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
        // Get manager defintion
        $managerDefinition = $container->getDefinition('birgit.task_manager');

        // Task handlers
        $handlerServiceIds = $container->findTaggedServiceIds('birgit.task_handler');

        foreach ($handlerServiceIds as $handlerServiceId => $handlerServiceAttributes) {
            $managerDefinition->addMethodCall(
                'addTaskHandler',
                array(new Reference($handlerServiceId))
            );
        }

        // Task queue handlers
        $handlerServiceIds = $container->findTaggedServiceIds('birgit.task_queue_handler');

        foreach ($handlerServiceIds as $handlerServiceId => $handlerServiceAttributes) {
            $managerDefinition->addMethodCall(
                'addTaskQueueHandler',
                array(new Reference($handlerServiceId))
            );
        }
    }
}
