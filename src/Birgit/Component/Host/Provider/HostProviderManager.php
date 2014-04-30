<?php

namespace Birgit\Component\Host\Provider;

use Birgit\Entity;

/**
 * Host provider manager
 */
class HostProviderManager
{
    /**
     * Host providers
     *
     * @var array
     */
	protected $hostProviders = array();

	public function addHostProvider($type, HostProviderInterface $hostProvider)
	{
		$this->hostProviders[(string) $type] = $hostProvider;
	}

	public function getHostProvider($type)
	{
		return $this->hostProviders[(string) $type];
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
