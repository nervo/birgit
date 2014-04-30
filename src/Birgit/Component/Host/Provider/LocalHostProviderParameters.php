<?php

namespace Birgit\Component\Host\Provider;

/**
 * Local Host provider Parameters
 */
class LocalHostProviderParameters extends HostProviderParameters
{
	protected $parameters = array(
		'workspace' => 'workspace'
	);

	public function getWorkspace()
	{
		return $this->get('workspace');
	}

	public function setWorkspace($workspace)
	{
		return $this->set('workspace', (string) $workspace);
	}
}
