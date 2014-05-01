<?php

namespace Birgit\Bundle\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Birgit\Bundle\CoreBundle\DependencyInjection\Compiler;

class BirgitCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container
            ->addCompilerPass(new Compiler\TaskCompilerPass())
            ->addCompilerPass(new Compiler\RepositoryCompilerPass())
            ->addCompilerPass(new Compiler\HostProviderCompilerPass());
    }
}
