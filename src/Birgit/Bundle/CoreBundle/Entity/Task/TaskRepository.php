<?php

namespace Birgit\Bundle\CoreBundle\Entity\Task;

use Birgit\Bundle\CoreBundle\Entity\EntityRepository;
use Birgit\Bundle\CoreBundle\Entity\Task\Task;

/**
 * Task Repository
 */
class TaskRepository extends EntityRepository
{
    public function create()
    {
        $task = new Task();
        
        return $task;
    }
}
