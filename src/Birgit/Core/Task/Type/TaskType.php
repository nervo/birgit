<?php

namespace Birgit\Core\Task\Type;

use Birgit\Component\Task\Type\TaskType as BaseTaskType;
use Birgit\Component\Handler\HandlerManager;
use Birgit\Core\Model\ModelManagerInterface;
use Birgit\Component\Task\TaskManager;

/**
 * Task Type
 */
abstract class TaskType extends BaseTaskType
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
        $this->modelManager = $modelManager;

        // Handler manager
        $this->handlerManager = $handlerManager;

        // Task manager
        $this->taskManager = $taskManager;
    }
}
