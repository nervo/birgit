<?php

namespace Birgit\Component\Task\Model\Task;

use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

/**
 * Tasks Iterator
 */
class TasksIterator implements \Iterator
{
    /**
     * Task Repository
     * 
     * @var TaskRepositoryInterface
     */
    protected $taskRepository;

    /**
     * Task Queue
     *
     * @var TaskQueue
     */
    protected $taskQueue;

    /**
     * Current
     *
     * @var Task|null
     */
    protected $current;

    /**
     * Ids
     * 
     * @var type 
     */
    protected $ids = array();

    /**
     * Constructor
     * 
     * @param TaskRepositoryInterface $taskRepository
     * @param TaskQueue               $taskQueue
     */
    public function __construct(
        TaskRepositoryInterface $taskRepository,
        TaskQueue $taskQueue
    ) {
        // Task repository
        $this->taskRepository = $taskRepository;

        // Task queue
        $this->taskQueue = $taskQueue;
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->ids = array();
        $this->next();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return (bool) $this->current;
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->current;
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->current->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->current = $this->taskRepository
            ->findFirstOneWithQueueAndIdNotIn($this->taskQueue, $this->ids);

        if ($this->current) {
            $this->ids[] = $this->current->getId();
        }
    }
}
