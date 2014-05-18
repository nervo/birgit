<?php

namespace Birgit\Model\Task\Queue;

use Doctrine\Common\Collections\Collection;

use Birgit\Component\Type\TypeModel;
use Birgit\Model\Task\Task;

abstract class TaskQueue extends TypeModel
{
    /**
     * Tasks
     *
     * @var Collection
     */
    protected $tasks;

    /**
     * Add task
     *
     * @param Task $task
     *
     * @return TaskQueue
     */
    public function addTask(Task $task)
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setQueue($this);
        }

        return $this;
    }

    /**
     * Remove task
     *
     * @param Task $task
     *
     * @return TaskQueue
     */
    public function removeTask(Task $task)
    {
        $this->tasks->removeElement($task);

        return $this;
    }

    /**
     * Get tasks
     *
     * @return Collection
     */
    public function getTasks()
    {
        return $this->tasks;
    }
}
