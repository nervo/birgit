<?php

namespace Birgit\Component\Repository;

/**
 * Git Repository Parameters
 */
class GitRepositoryParameters extends RepositoryParameters
{
	protected $parameters = array(
		'path' => null
	);

	public function getPath()
	{
		return $this->get('path');
	}

	public function setPath($path)
	{
		return $this->set('path', (string) $path);
	}
}
