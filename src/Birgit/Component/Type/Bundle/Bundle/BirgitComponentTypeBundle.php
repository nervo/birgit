<?php

namespace Birgit\Component\Type\Bundle\Bundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Birgit\Component\Type\Bundle\Bundle\DependencyInjection\Compiler;

/**
 * Birgit Component Type Bundle
 */
class BirgitComponentTypeBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container
            ->addCompilerPass(new Compiler\TypeResolverCompilerPass());
    }
}
