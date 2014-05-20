<?php

namespace Birgit\Bundle\CoreBundle\Entity\Task\Queue;

use Birgit\Bundle\CoreBundle\Entity\EntityRepository;
use Birgit\Bundle\CoreBundle\Entity\Task\Queue\TaskQueue;

/**
 * Task queue Repository
 */
class TaskQueueRepository extends EntityRepository
{
    public function create()
    {
        $taskQueue = new TaskQueue();
        
        return $taskQueue;
    }
}
