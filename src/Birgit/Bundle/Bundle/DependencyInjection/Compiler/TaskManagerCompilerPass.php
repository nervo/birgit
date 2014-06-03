<?php

namespace Birgit\Bundle\Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Task Manager compiler pass
 */
class TaskManagerCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        // Get manager defintion
        $managerDefinition = $container->getDefinition('birgit.task_manager');

        // Set manager class
        $managerDefinition
            ->setClass('Birgit\\Domain\\Task\\TaskManager');
    }
}
