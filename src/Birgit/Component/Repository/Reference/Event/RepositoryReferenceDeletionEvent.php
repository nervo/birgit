<?php

namespace Birgit\Component\Repository\Reference\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Repository reference Deletion Event
 */
class RepositoryReferenceDeletionEvent extends Event
{
	protected $name;
	protected $revision;

	public function __construct($name, $revision)
	{
		$this->name = $name;
		$this->revision = $revision;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getRevision()
	{
		return $this->revision;
	}
}
