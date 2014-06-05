<?php

namespace Birgit\Core\Bundle\Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Birgit\Core\Bundle\Bundle\DependencyInjection\Compiler;

class BirgitCoreBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container
            ->addCompilerPass(new Compiler\TaskManagerCompilerPass());
    }
}
