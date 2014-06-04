<?php

namespace Birgit\Core\Task\Queue\Context;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

use Birgit\Component\Task\Queue\Context\TaskQueueContext;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Core\Model\Project\Environment\ProjectEnvironment;

/**
 * Project environment Task queue Context
 */
class ProjectEnvironmentTaskQueueContext extends TaskQueueContext implements ProjectEnvironmentTaskQueueContextInterface
{
    protected $projectEnvironment;

    public function __construct(
        ProjectEnvironment $projectEnvironment,
        TaskQueue $queue,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->projectEnvironment = $projectEnvironment;

        parent::__construct($taskQueue, $eventDispatcher, $logger);
    }

    public function getProjectEnvironment()
    {
        return $this->projectEnvironment;
    }

    public function getProject()
    {
        return $this->getProjectEnvironment()->getProject();
    }
}
