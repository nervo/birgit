<?php

namespace Birgit\Domain\Task\Handler;

use Birgit\Domain\Handler\Handler;
use Birgit\Model\Task\Task;
use Birgit\Domain\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Domain\Handler\HandlerManager;
use Birgit\Model\ModelManagerInterface;
use Birgit\Domain\Task\TaskManager;

/**
 * Task Handler
 */
abstract class TaskHandler extends Handler implements TaskHandlerInterface
{
    /**
     * Model Manager
     *
     * @var ModelManagerInterface
     */
    protected $modelManager;

    /**
     * Handler Manager
     *
     * @var HandlerManager
     */
    protected $handlerManager;

    /**
     * Task Manager
     *
     * @var TaskManager
     */
    protected $taskManager;

    /**
     * Constructor
     *
     * @param ModelManagerInterface $modelManager
     * @param HandlerManager        $handlerManager
     * @param TaskManager           $taskManager
     */
    public function __construct(
        ModelManagerInterface $modelManager,
        HandlerManager $handlerManager,
        TaskManager $taskManager
    ) {
        // Model manager
        $this->modelManager   = $modelManager;

        // Handler manager
        $this->handlerManager = $handlerManager;

        // Task manager
        $this->taskManager = $taskManager;
    }

    abstract public function run(Task $task, TaskQueueContextInterface $context);
}
