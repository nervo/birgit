<?php

namespace Birgit\Bundle\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Birgit\Entity\HostProvider;

class LoadHostProviderData extends AbstractFixture implements OrderedFixtureInterface
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
        $hostProvidersDefinitions = array(
            'local' => array(
                'type'       => 'local',
                'parameters' => array(
                    'workspace' => 'workspace'
                )
            )
        );

        $hostProviders = array();

        foreach ($hostProvidersDefinitions as $hostProviderName => $hostProviderParameters) {
            $hostProviders[$hostProviderName] = (new HostProvider())
                ->setType($hostProviderParameters['type'])
                ->setParameters($hostProviderParameters['parameters']);

            $manager->persist($hostProviders[$hostProviderName]);

            $this->addReference('host_provider.' . $hostProviderName, $hostProviders[$hostProviderName]);
        }

        $manager->flush();
    }
}
