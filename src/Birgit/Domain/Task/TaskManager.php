<?php

namespace Birgit\Domain\Task;

use Doctrine\Common\Persistence\ManagerRegistry;

use Birgit\Domain\Task\Handler\TaskHandlerInterface;
use Birgit\Domain\Task\Queue\Handler\TaskQueueHandlerInterface;
use Birgit\Model\Task\Task;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Component\Parameters\Parameters;
use Birgit\Component\Exception\Exception;

/**
 * Task Manager
 */
class TaskManager
{
    protected $doctrineManagerRegistry;

    /**
     * Task handlers
     *
     * @var array
     */
    protected $taskHandlers = array();

    /**
     * Task queue handlers
     *
     * @var array
     */
    protected $taskQueueHandlers = array();

    public function __construct(ManagerRegistry $doctrineManagerRegistry)
    {
        $this->doctrineManagerRegistry = $doctrineManagerRegistry;
    }
    
    public function addTaskHandler(TaskHandlerInterface $handler)
    {
        $this->taskHandlers[] = $handler;
        
        return $this;
    }

    public function addTaskQueueHandler(TaskQueueHandlerInterface $handler)
    {
        $this->taskQueueHandlers[] = $handler;
        
        return $this;
    }
    
    public function getTaskHandler(Task $task)
    {
        $type = $task->getType();

        foreach ($this->taskHandlers as $handler) {
            if ($handler->getType() === $type) {
                return $handler;
            }
        }

        throw new Exception(sprintf('Task handler type "%s" not found', $type));
    }

    public function getTaskQueueHandler(TaskQueue $taskQueue)
    {
        $type = $taskQueue->getType();

        foreach ($this->taskQueueHandlers as $handler) {
            if ($handler->getType() === $type) {
                return $handler;
            }
        }

        throw new Exception(sprintf('Task queue handler type "%s" not found', $type));
    }
    
    public function createTask($type, Parameters $parameters = null)
    {
        $task = $this->doctrineManagerRegistry
            ->getRepository('Birgit:Task\Task')
            ->create()
                ->setType((string) $type);
        
        if ($parameters) {
            $task->setParameters($parameters);
        }
        
        return $task;
    }
    
    public function createTaskQueue($type, Parameters $parameters = null)
    {
        $taskQueue = $this->doctrineManagerRegistry
            ->getRepository('Birgit:Task\Queue\TaskQueue')
            ->create()
                ->setType((string) $type);
        
        if ($parameters) {
            $taskQueue->setParameters($parameters);
        }
        
        return $taskQueue;
    }
}
