<?php

namespace Birgit\Domain\Project\Task\Queue\Handler;

use Birgit\Domain\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Domain\Context\ContextInterface;
use Birgit\Domain\Project\Task\Queue\Context\ProjectTaskQueueContext;
use Birgit\Model\ModelManagerInterface;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Domain\Handler\HandlerManager;

/**
 * Project Task queue Handler
 */
class ProjectTaskQueueHandler extends TaskQueueHandler
{
    protected $modelManager;

    public function __construct(
        ModelManagerInterface $modelManager,
        HandlerManager $handlerManager
    ) {
        $this->modelManager = $modelManager;

        parent::__construct($handlerManager);
    }

    public function getType()
    {
        return 'project';
    }

    protected function preRun(TaskQueue $taskQueue, ContextInterface $context)
    {
        // Get project
        $project = $this->modelManager
            ->getProjectRepository()
            ->get(
                $taskQueue->getHandlerDefinition()->getParameters()->get('project_name')
            );

        return new ProjectTaskQueueContext(
            $project,
            $taskQueue,
            $context
        );
    }
}
