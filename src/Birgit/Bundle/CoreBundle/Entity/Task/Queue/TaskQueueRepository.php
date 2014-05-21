<?php

namespace Birgit\Bundle\CoreBundle\Entity\Task\Queue;

use Birgit\Bundle\CoreBundle\Entity\EntityRepository;
use Birgit\Model\Task\Queue\TaskQueueRepositoryInterface;
use Birgit\Bundle\CoreBundle\Entity\Task\Queue\TaskQueue;

/**
 * Task queue Repository
 */
class TaskQueueRepository extends EntityRepository implements TaskQueueRepositoryInterface
{
    public function create()
    {
        $taskQueue = new TaskQueue();
        
        return $taskQueue;
    }
}
