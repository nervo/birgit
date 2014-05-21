<?php

namespace Birgit\Domain\Cron\Task\Queue\Handler;

use Psr\Log\LoggerInterface;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Birgit\Domain\Cron\Task\Queue\Handler\CronTaskQueueHandler;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\Project\ProjectRepositoryInterface;
use Birgit\Model\Project\Reference\ProjectReferenceRepositoryInterface;
use Birgit\Domain\Task\TaskManager;

/**
 * Project reference Cron Task queue Handler
 */
class ProjectReferenceCronTaskQueueHandler extends CronTaskQueueHandler
{
    protected $projectRepository;
    protected $projectReferenceRepository;

    public function __construct(
        ProjectRepositoryInterface $projectRepository,
        ProjectReferenceRepositoryInterface $projectReferenceRepository,
        TaskManager $taskManager,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->projectRepository = $projectRepository;
        $this->projectReferenceRepository = $projectReferenceRepository;

        parent::__construct($taskManager, $eventDispatcher, $logger);
    }

    public function getType()
    {
        return 'project_reference_cron';
    }

    protected function preRun(TaskQueue $taskQueue)
    {
        // Get project
        $project = $this->projectRepository
            ->get(
                $taskQueue->getParameters()->get('project_name')
            );

        // Get project reference
        $projectReference = $this->projectReferenceRepository
            ->get(
                $taskQueue->getParameters()->get('project_reference_name'),
                $project
            );

        return new ProjectReferenceTaskQueueContext(
            $projectReference,
            $taskQueue,
            $this->logger
        );
    }
}
