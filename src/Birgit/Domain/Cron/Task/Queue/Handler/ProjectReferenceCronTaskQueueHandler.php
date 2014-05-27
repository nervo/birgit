<?php

namespace Birgit\Domain\Cron\Task\Queue\Handler;

use Birgit\Domain\Cron\Task\Queue\Handler\CronTaskQueueHandler;
use Birgit\Domain\Context\ContextInterface;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\ModelManagerInterface;
use Birgit\Domain\Handler\HandlerManager;

/**
 * Project reference Cron Task queue Handler
 */
class ProjectReferenceCronTaskQueueHandler extends CronTaskQueueHandler
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
        return 'project_reference_cron';
    }

    protected function preRun(TaskQueue $taskQueue, ContextInterface $context)
    {
        // Get project
        $project = $this->modelManager
            ->getProjectRepository()
            ->get(
                $taskQueue->getHandlerDefinition()->getParameters()->get('project_name')
            );

        // Get project reference
        $projectReference = $this->modelManager
            ->getProjectReferenceRepository()
            ->get(
                $taskQueue->getHandlerDefinition()->getParameters()->get('project_reference_name'),
                $project
            );

        return new ProjectReferenceTaskQueueContext(
            $projectReference,
            $taskQueue,
            $context
        );
    }
}
