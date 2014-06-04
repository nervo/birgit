<?php

namespace Birgit\Core\Bundle\Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Handler compiler pass
 */
class HandlerCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        // Get manager defintion
        $managerDefinition = $container->getDefinition('birgit.handler_manager');

        // Project handlers
        $handlerServiceIds = $container->findTaggedServiceIds('birgit.project_handler');

        foreach ($handlerServiceIds as $handlerServiceId => $handlerServiceAttributes) {
            $managerDefinition->addMethodCall(
                'addProjectHandler',
                array(new Reference($handlerServiceId))
            );
        }

        // Project environment handlers
        $handlerServiceIds = $container->findTaggedServiceIds('birgit.project_environment_handler');

        foreach ($handlerServiceIds as $handlerServiceId => $handlerServiceAttributes) {
            $managerDefinition->addMethodCall(
                'addProjectEnvironmentHandler',
                array(new Reference($handlerServiceId))
            );
        }

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
