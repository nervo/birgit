<?php

namespace Birgit\Bundle\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

use Doctrine\DBAL\Types\Type;

use Birgit\Bundle\CoreBundle\DependencyInjection\Compiler;

class BirgitCoreBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container
            ->addCompilerPass(new Compiler\TaskCompilerPass())
            ->addCompilerPass(new Compiler\ProjectCompilerPass());
    }
    
    public function boot()
    {
        $entityManager = $this->container
            ->get('doctrine')
            ->getEntityManager();
        
        if (!Type::hasType('parameters')) {
            Type::addType(
                'parameters',
                'Birgit\Component\Parameters\Doctrine\ParametersType'
            );

            $entityManager->getConnection()
                ->getDatabasePlatform()
                ->registerDoctrineTypeMapping('parameters', 'parameters');
        }
    }
}
