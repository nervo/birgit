<?php

namespace Birgit\Component\Host\Provider;

/**
 * Local Host provider Parameters
 */
class LocalHostProviderParameters extends HostProviderParameters
{
	public function getWorkspace()
	{
		return $this->get('workspace', 'workspace');
	}

	public function setWorkspace($workspace)
	{
		return $this->set('workspace', $workspace);
	}
}
