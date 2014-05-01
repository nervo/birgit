<?php

namespace Birgit\Component\Host\Provider;

use Birgit\Entity;

/**
 * Host provider manager
 */
class HostProviderManager
{
    /**
     * Host provider types
     *
     * @var array
     */
    protected $hostProviderTypes = array();

    public function addHostProviderType($type, HostProviderInterface $hostProvider)
    {
        $this->hostProviderTypes[(string) $type] = $hostProvider;
    }

    public function getHostProviderType($type)
    {
        return $this->hostProviderTypes[(string) $type];
    }

    /**
     * Create host
     *
     * @param Entity\Project\Environment  $projectEnvironmentEntity
     * @param Entity\Repository\Reference $repositoryReferenceEntity
     *
     * @return Host
     */
    public function createHost(Entity\Project\Environment $projectEnvironmentEntity, Entity\Repository\Reference $repositoryReferenceEntity)
    {
        // Get host provider entity
        $hostProviderEntity = $projectEnvironmentEntity->getHostProvider();

        // Get host provider
        $hostProvider = $this->getHostProvider(
            $hostProviderEntity->getType()
        );

        // Get host provider parameters
        $hostProviderParameters = (new LocalHostProviderParameters())
            ->merge(
                $hostProviderEntity->getParameters()
            );

        var_dump($hostProviderParameters);

        var_dump($hostProvider);

        die;
    }
}
