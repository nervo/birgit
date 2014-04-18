<?php

namespace Birgit\Bundle\HostBundle\DataFixtures\ORM;

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
                'path' => 'data/projects'
            )
        );

        $hostProviders = array();

        foreach ($hostProvidersDefinitions as $hostProviderName => $hostProviderParameters) {
            $hostProviders[$hostProviderName] = (new HostProvider())
                ->setPath($hostProviderParameters['path']);

            $manager->persist($hostProviders[$hostProviderName]);

            $this->addReference('host_provider.' . $hostProviderName, $hostProviders[$hostProviderName]);
        }

        $manager->flush();
    }
}
