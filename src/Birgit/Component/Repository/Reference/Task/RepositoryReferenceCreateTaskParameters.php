<?php

namespace Birgit\Component\Repository\Reference\Task;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Doctrine\Common\Persistence\ManagerRegistry;

use Birgit\Component\Task\TaskParameters;

/**
 * Repository reference Create Task
 */
class RepositoryReferenceCreateTaskParameters extends TaskParameters
{
	protected $parameters = array(
		'name'     => null,
		'revision' => null
	);

	public function getName()
	{
		return $this->get('name');
	}

	public function setName($name)
	{
		return $this->set('name', (string) $name);
	}

	public function getRevision()
	{
		return $this->get('revision');
	}

	public function setRevision($revision)
	{
		return $this->set('revision', (string) $revision);
	}
}
