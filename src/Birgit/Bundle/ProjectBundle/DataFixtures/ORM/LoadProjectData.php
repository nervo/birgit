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
        return 2;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $projectsDefinitions = array(
            'test'  => array(
                'repository' => 'test'
            ),
            'adele' => array(
                'repository' => 'adele'
            )
        );

        $projects = array();

        foreach ($projectsDefinitions as $projectName => $projectParameters) {
            $projects[$projectName] = new Project();
            $projects[$projectName]->setName($projectName);
            $projects[$projectName]->setRepository($this->getReference('repository_' . $projectParameters['repository']));

            $manager->persist($projects[$projectName]);

            $this->addReference('project_' . $projectName, $projects[$projectName]);
        }

        $manager->flush();
    }
}
