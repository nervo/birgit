<?php

namespace Birgit\Component\Task\Model\Task\Queue;

/**
 * Task Queue Repository Iterator
 */
class TaskQueueRepositoryIterator implements \Iterator
{
    /**
     * Task Queue Repository
     * 
     * @var type 
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
     * @var type 
     */
    protected $ids = array();

    /**
     * Constructor
     * 
     * @param TaskQueueRepositoryInterface $taskQueueRepository
     */
    public function __construct(TaskQueueRepositoryInterface $taskQueueRepository)
    {
        // Task queue repository
        $this->taskQueueRepository = $taskQueueRepository;
    }

    public function rewind()
    {
        $this->next();
    }

    public function valid()
    {
        return (bool) $this->current;
    }

    public function current()
    {
        return $this->current;
    }

    public function key()
    {
        return $this->current->getId();
    }

    public function next()
    {
        $this->current = $this->taskQueueRepository
            ->findFirstOneWithIdNotIn($this->ids);

        if ($this->current) {
            $this->ids[] = $this->current->getId();
        }
    }
}
