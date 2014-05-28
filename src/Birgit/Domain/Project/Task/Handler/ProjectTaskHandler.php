<?php

namespace Birgit\Domain\Project\Task\Handler;

use Birgit\Domain\Task\Handler\TaskHandler;
use Birgit\Domain\Handler\HandlerManager;
use Birgit\Model\ModelManagerInterface;

/**
 * Project - Task handler
 */
abstract class ProjectTaskHandler extends TaskHandler
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
}
