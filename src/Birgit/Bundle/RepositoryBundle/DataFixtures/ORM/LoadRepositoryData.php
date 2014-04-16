<?php

namespace Birgit\Bundle\RepositoryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Birgit\Bundle\RepositoryBundle\Entity\Repository;

class LoadRepositoryData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $repository = new Repository();
        $repository->setUrl('git@github.com:nervo/birgit-test.git');

        $manager->persist($repository);
        $manager->flush();

        $this->addReference('repository_1', $repository);
    }
}
