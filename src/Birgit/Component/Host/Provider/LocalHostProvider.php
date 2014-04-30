<?php

namespace Birgit\Component\Host\Provider;

/**
 * Local Host provider
 */
class LocalHostProvider extends HostProvider
{
	protected $rootDir;

	public function __construct($rootDir)
	{
		$this->rootDir = (string) $rootDir;
	}
}
