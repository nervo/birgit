<?php

namespace Birgit\Core\Bundle\Bundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

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
            ->setClass('Birgit\\Core\\Task\\TaskManager');
    }
}
