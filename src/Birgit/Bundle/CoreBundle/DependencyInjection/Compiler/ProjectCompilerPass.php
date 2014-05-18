<?php

namespace Birgit\Bundle\CoreBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Project compiler pass
 */
class ProjectCompilerPass implements CompilerPassInterface
{
    /**
     * Process
     *
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        // Get manager defintion
        $managerDefinition = $container->getDefinition('birgit.project_manager');

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
    }
}
