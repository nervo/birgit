<?php

namespace Birgit\Core\Task\Queue\Context;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

use Birgit\Component\Task\Queue\Context\TaskQueueContext;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Core\Model\Project\Reference\ProjectReference;

/**
 * Project reference Task queue Context
 */
class ProjectReferenceTaskQueueContext extends TaskQueueContext implements ProjectReferenceTaskQueueContextInterface
{
    protected $projectReference;

    public function __construct(
        ProjectReference $projectReference,
        TaskQueue $taskQueue,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->projectReference = $projectReference;

        parent::__construct($taskQueue, $eventDispatcher, $logger);
    }

    public function getProjectReference()
    {
        return $this->projectReference;
    }

    public function getProject()
    {
        return $this->getProjectReference()->getProject();
    }
}
