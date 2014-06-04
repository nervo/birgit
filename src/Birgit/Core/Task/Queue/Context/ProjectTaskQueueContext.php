<?php

namespace Birgit\Core\Task\Queue\Context;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

use Birgit\Component\Task\Queue\Context\TaskQueueContext;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Core\Model\Project\Project;

/**
 * Project Task queue Context
 */
class ProjectTaskQueueContext extends TaskQueueContext implements ProjectTaskQueueContextInterface
{
    protected $project;

    public function __construct(
        Project $project,
        TaskQueue $taskQueue,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->project = $project;

        parent::__construct($taskQueue, $eventDispatcher, $logger);
    }

    public function getProject()
    {
        return $this->project;
    }
}
