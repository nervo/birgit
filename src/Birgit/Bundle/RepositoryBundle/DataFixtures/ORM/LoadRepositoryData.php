<?php

namespace Birgit\Bundle\RepositoryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Birgit\Bundle\RepositoryBundle\Entity\Repository;

class LoadRepositoryData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $repository = new Repository();
        $repository->setUrl('git@github.com:nervo/birgit-test.git');

        $manager->persist($repository);
        $manager->flush();
    }
}
