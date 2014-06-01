<?php

namespace Birgit\Bundle\DoctrineBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

use Doctrine\DBAL\Types\Type;

class BirgitDoctrineBundle extends Bundle
{
    public function boot()
    {
        $entityManager = $this->container
            ->get('doctrine')
            ->getManager();

        if (!Type::hasType('parameters')) {
            Type::addType(
                'parameters',
                'Birgit\Bundle\DoctrineBundle\Types\ParametersType'
            );

            $entityManager->getConnection()
                ->getDatabasePlatform()
                ->registerDoctrineTypeMapping('parameters', 'parameters');
        }
    }
}
