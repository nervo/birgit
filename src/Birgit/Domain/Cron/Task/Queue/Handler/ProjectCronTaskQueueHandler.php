<?php

namespace Birgit\Domain\Cron\Task\Queue\Handler;

use Birgit\Domain\Cron\Task\Queue\Handler\CronTaskQueueHandler;
use Birgit\Domain\Context\ContextInterface;
use Birgit\Domain\Project\Task\Queue\Context\ProjectTaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\ModelManagerInterface;
use Birgit\Domain\Handler\HandlerManager;

/**
 * Project Cron Task queue Handler
 */
class ProjectCronTaskQueueHandler extends CronTaskQueueHandler
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
        return 'project_cron';
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
