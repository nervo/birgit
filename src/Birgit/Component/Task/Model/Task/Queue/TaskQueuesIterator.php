<?php

namespace Birgit\Component\Task\Model\Task\Queue;

/**
 * Task Queues Iterator
 */
class TaskQueuesIterator implements \Iterator
{
    /**
     * Task Queue Repository
     * 
     * @var TaskQueueRepositoryInterface
     */
    protected $taskQueueRepository;

    /**
     * Current
     *
     * @var TaskQueue|null
     */
    protected $current;

    /**
     * Ids
     * 
     * @var array
     */
    protected $ids = array();

    /**
     * Constructor
     * 
     * @param TaskQueueRepositoryInterface $taskQueueRepository
     */
    public function __construct(
        TaskQueueRepositoryInterface $taskQueueRepository
    ) {
        // Task queue repository
        $this->taskQueueRepository = $taskQueueRepository;
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
        $this->current = $this->taskQueueRepository
            ->findFirstOneWithIdNotIn($this->ids);

        if ($this->current) {
            $this->ids[] = $this->current->getId();
        }
    }
}
