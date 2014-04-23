<?php

namespace Birgit\Bundle\RepositoryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Birgit\Entity\Repository;

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
        $repositoriesDefinitions = array(
            'test'  => array(
                'path' => 'git@github.com:nervo/birgit-test.git'
            ),
            'adele' => array(
                'path' => 'git@github.com:Elao/adele.git'
            )
        );

        $repositories = array();

        foreach ($repositoriesDefinitions as $repositoryName => $repositoryParameters) {
            $repositories[$repositoryName] = (new Repository())
                ->setPath($repositoryParameters['path']);

            $manager->persist($repositories[$repositoryName]);

            $this->addReference('repository.' . $repositoryName, $repositories[$repositoryName]);
        }

        $manager->flush();
    }
}
