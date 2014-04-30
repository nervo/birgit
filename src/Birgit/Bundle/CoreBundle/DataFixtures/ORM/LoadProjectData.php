<?php

namespace Birgit\Bundle\CoreBundle\DataFixtures\ORM;

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
                'repository'   => 'test',
                'environments' => array(
                    'test'    => array(
                        'repository_reference_pattern' => '*',
                        'host_provider'                => 'local',
                        'active'                       => true
                    ),
                    'quality' => array(
                        'repository_reference_pattern' => '*',
                        'host_provider'                => 'local',
                        'active'                       => true
                    )
                ),
                'active'       => true
            ),
            'adele' => array(
                'repository'   => 'adele',
                'environments' => array(
                    'test'    => array(
                        'repository_reference_pattern' => '*',
                        'host_provider'                => 'local',
                        'active'                       => true
                    ),
                    'quality' => array(
                        'repository_reference_pattern' => '*',
                        'host_provider'                => 'local',
                        'active'                       => true
                    ),
                    'demo'    => array(
                        'repository_reference_pattern' => '*',
                        'host_provider'                => 'local',
                        'active'                       => true
                    )
                ),
                'active'       => false
            )
        );

        $projects = array();

        foreach ($projectsDefinitions as $projectName => $projectParameters) {
            $projects[$projectName] = (new Project())
                ->setName($projectName)
                ->setRepository($this->getReference('repository.' . $projectParameters['repository']));

            $projectEnvironments = array();

            foreach ($projectParameters['environments'] as $projectEnvironmentName => $projectEnvironmentParameters) {
                $projectEnvironments[$projectEnvironmentName] = (new Project\Environment())
                    ->setName($projectEnvironmentName)
                    ->setRepositoryReferencePattern($projectEnvironmentParameters['repository_reference_pattern'])
                    ->setHostProvider($this->getReference('host_provider.' . $projectEnvironmentParameters['host_provider']))
                    ->setActive($projectEnvironmentParameters['active']);

                $projects[$projectName]
                    ->addEnvironment($projectEnvironments[$projectEnvironmentName]);
            }

            $projects[$projectName]
                ->setActive($projectParameters['active']);

            $manager->persist($projects[$projectName]);

            $this->addReference('project.' . $projectName, $projects[$projectName]);
        }

        $manager->flush();
    }
}
