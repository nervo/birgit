<?php

namespace Birgit\Domain\Task\Queue\Handler;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Component\Type\TypeHandler;
use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Domain\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Domain\Task\TaskManager;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Domain\Task\Event\TaskQueueEvent;
use Birgit\Domain\Task\TaskEvents;

/**
 * Task queue Handler
 */
abstract class TaskQueueHandler extends TypeHandler implements TaskQueueHandlerInterface
{
    protected $taskManager;
    protected $eventDispatcher;
    protected $logger;
    
    public function __construct(TaskManager $taskManager, EventDispatcherInterface $eventDispatcher, LoggerInterface $logger)
    {
        $this->taskManager = $taskManager;
        $this->eventDispatcher = $eventDispatcher;
        $this->logger = $logger;
    }
    
    protected function preRun(TaskQueue $taskQueue)
    {
        return new TaskQueueContext(
            $taskQueue,
            $this->logger
        );
    }
    
    public function run(TaskQueue $taskQueue)
    {
        // Pre run
        $context = $this->preRun($taskQueue);

        // Log
        $context->getLogger()->notice(sprintf('Task queue Handler: Run task queue type "%s"', $taskQueue->getType()), $taskQueue->getParameters()->all());

        // Dispatch event
        $this->eventDispatcher
            ->dispatch(
                TaskEvents::TASK_QUEUE . '.' . $this->getType(),
                new TaskQueueEvent($taskQueue)
            );
        
        $tasks = $taskQueue->getTasks()->toArray();
        
        while ($tasks) {
            $task = array_pop($tasks);
    
            // Log
            $context->getLogger()->notice(sprintf('Task queue Handler: Run task type "%s"', $task->getType()), $task->getParameters()->all());
            
            $this->taskManager
                ->getTaskHandler($task)
                    ->run($task, $context);
        }
        
        // Post run
        $this->postRun($context);
    }
    
    protected function postRun(TaskQueueContextInterface $context)
    {
    }
}
