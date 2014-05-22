<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Task;

use Birgit\Model;

class Task extends Model\Task\Task
{
    /**
     * Id
     *
     * @var int
     */
    private $id;

    /**
     * Queue
     *
     * @var Model\Task\Queue\TaskQueue
     */
    private $queue;
    
    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setQueue(Model\Task\Queue\TaskQueue $queue)
    {
        $this->queue = $queue;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueue()
    {
        return $this->queue;
    }
}
