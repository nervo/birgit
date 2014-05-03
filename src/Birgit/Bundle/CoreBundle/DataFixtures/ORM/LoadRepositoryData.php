<?php

namespace Birgit\Bundle\CoreBundle\DataFixtures\ORM;

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
                'type'       => 'git',
                'parameters' => array(
                    //'path' => 'git@github.com:nervo/birgit-test.git'
                    'path' => '~/workspace/birgit-test'
                )
            ),
            'adele' => array(
                'type'       => 'git',
                'parameters' => array(
                    //'path' => 'git@github.com:Elao/adele.git'
                    'path' => '~/workspace/elao/adele'
                )
            )
        );

        $repositories = array();

        foreach ($repositoriesDefinitions as $repositoryName => $repositoryParameters) {
            $repositories[$repositoryName] = $manager->getRepository('Birgit:Repository\Repository')
                ->create()
                    ->setType($repositoryParameters['type'])
                    ->setParameters($repositoryParameters['parameters']);

            $manager->persist($repositories[$repositoryName]);

            $this->addReference('repository.' . $repositoryName, $repositories[$repositoryName]);
        }

        $manager->flush();
    }
}
