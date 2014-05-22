<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Task;

use Birgit\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Model\Task\TaskRepositoryInterface;
use Birgit\Component\Parameters\Parameters;

/**
 * Task Repository
 */
class TaskRepository extends EntityRepository implements TaskRepositoryInterface
{
    public function create($type, Parameters $parameters = null)
    {
        $task = $this->createEntity();
        
        $task
            ->setType((string) $type);

        if ($parameters) {
            $task->setParameters($parameters);
        }
        
        return $task;
    }
}
