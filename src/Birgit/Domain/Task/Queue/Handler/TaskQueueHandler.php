<?php

namespace Birgit\Domain\Task\Queue\Handler;

use Birgit\Domain\Handler\Handler;
use Birgit\Domain\Context\ContextInterface;
use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Domain\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Domain\Handler\HandlerManager;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Domain\Task\Event\TaskQueueEvent;
use Birgit\Domain\Task\TaskEvents;

/**
 * Task queue Handler
 */
abstract class TaskQueueHandler extends Handler implements TaskQueueHandlerInterface
{
    protected $handlerManager;

    public function __construct(
        HandlerManager $handlerManager
    ) {
        $this->handlerManager = $handlerManager;
    }

    protected function preRun(TaskQueue $taskQueue, ContextInterface $context)
    {
        return new TaskQueueContext(
            $taskQueue,
            $context
        );
    }

    public function run(TaskQueue $taskQueue, ContextInterface $context)
    {
        // Pre run
        $context = $this->preRun($taskQueue, $context);

        // Log
        $context->getLogger()->notice(sprintf('Task Queue: %s', $taskQueue->getHandlerDefinition()->getType()), $taskQueue->getHandlerDefinition()->getParameters()->all());

        // Dispatch event
        $context->getEventDispatcher()
            ->dispatch(
                TaskEvents::TASK_QUEUE . '.' . $this->getType(),
                new TaskQueueEvent($taskQueue)
            );

        $tasks = $taskQueue->getTasks()->toArray();

        while ($tasks) {
            $task = array_pop($tasks);

            // Log
            $context->getLogger()->notice(sprintf('> Task: %s', $task->getHandlerDefinition()->getType()), $task->getHandlerDefinition()->getParameters()->all());

            $this->handlerManager
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
