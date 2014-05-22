<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Task\Queue;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Model;

/**
 * Task queue
 */
class TaskQueue extends Model\Task\Queue\TaskQueue
{
    /**
     * Id
     *
     * @var int
     */
    private $id;

    /**
     * Tasks
     *
     * @var ArrayCollection
     */
    private $tasks;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // Tasks
        $this->tasks = new ArrayCollection();
        
        parent::__construct();
    }

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
    public function addTask(Model\Task\Task $task)
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setQueue($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeTask(Model\Task\Task $task)
    {
        $this->tasks->removeElement($task);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}
