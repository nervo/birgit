<?php

namespace Birgit\Bundle\Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Birgit\Bundle\Bundle\DependencyInjection\Compiler;

/**
 * Birgit bundle
 */
class BirgitBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container
            ->addCompilerPass(new Compiler\HandlerCompilerPass());
    }
}
