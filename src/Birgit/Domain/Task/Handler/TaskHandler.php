<?php

namespace Birgit\Domain\Task\Handler;

use Birgit\Domain\Handler\Handler;
use Birgit\Model\Task\Task;
use Birgit\Domain\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Domain\Handler\HandlerManager;
use Birgit\Model\ModelManagerInterface;

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
     * @var HandlerManager
     */
    protected $handlerManager;

    /**
     * Constructor
     *
     * @param ModelManagerInterface $modelManager
     * @param HandlerManager        $handlerManager
     */
    public function __construct(
        ModelManagerInterface $modelManager,
        HandlerManager $handlerManager
    ) {
        $this->modelManager   = $modelManager;
        $this->handlerManager = $handlerManager;
    }

    abstract public function run(Task $task, TaskQueueContextInterface $context);
}
