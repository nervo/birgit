<?php

namespace Birgit\Domain\Task\Queue\Handler;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Handler\Handler;
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
    protected $eventDispatcher;
    protected $logger;

    public function __construct(
        HandlerManager $handlerManager,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->handlerManager = $handlerManager;
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
        $context->getLogger()->notice(sprintf('Task Queue: %s', $taskQueue->getHandlerDefinition()->getType()), $taskQueue->getHandlerDefinition()->getParameters()->all());

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
            $context->getLogger()->notice(sprintf('Task: %s', $task->getHandlerDefinition()->getType()), $task->getHandlerDefinition()->getParameters()->all());

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
