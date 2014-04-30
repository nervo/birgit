<?php

namespace Birgit\Component\Host\Provider;

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
}
