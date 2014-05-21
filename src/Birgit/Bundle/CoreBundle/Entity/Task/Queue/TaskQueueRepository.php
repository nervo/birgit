<?php

namespace Birgit\Bundle\CoreBundle\Entity\Task\Queue;

use Birgit\Bundle\CoreBundle\Entity\EntityRepository;
use Birgit\Model\Task\Queue\TaskQueueRepositoryInterface;
use Birgit\Component\Parameters\Parameters;

/**
 * Task queue Repository
 */
class TaskQueueRepository extends EntityRepository implements TaskQueueRepositoryInterface
{
    public function create($type, Parameters $parameters = null)
    {
        $taskQueue = $this->createEntity();
        
        $taskQueue
            ->setType((string) $type);

        if ($parameters) {
            $taskQueue->setParameters($parameters);
        }
        
        return $taskQueue;
    }
}
