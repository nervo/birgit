<?php

namespace Birgit\Bundle\ProjectBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Birgit\Entity\Project;

class LoadProjectData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $projectsDefinitions = array(
            'test'  => array(
                'repository'    => 'test',
                'host_provider' => 'local'
            ),
            'adele' => array(
                'repository'    => 'adele',
                'host_provider' => 'local'
            )
        );

        $projects = array();

        foreach ($projectsDefinitions as $projectName => $projectParameters) {
            $projects[$projectName] = new Project();
            $projects[$projectName]
                ->setName($projectName)
                ->setRepository($this->getReference('repository.' . $projectParameters['repository']))
                ->setHostProvider($this->getReference('host_provider.' . $projectParameters['host_provider']));

            $manager->persist($projects[$projectName]);

            $this->addReference('project.' . $projectName, $projects[$projectName]);
        }

        $manager->flush();
    }
}
