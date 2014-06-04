<?php

namespace Birgit\Core\Task\Queue\Context;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

use Birgit\Component\Task\Queue\Context\TaskQueueContext;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Core\Model\Project\Reference\Revision\ProjectReferenceRevision;

/**
 * Project reference revision Task queue Context
 */
class ProjectReferenceRevisionTaskQueueContext extends TaskQueueContext implements ProjectReferenceRevisionTaskQueueContextInterface
{
    protected $projectReferenceRevision;

    public function __construct(
        ProjectReferenceRevision $projectReferenceRevision,
        TaskQueue $queue,
        EventDispatcherInterface $eventDispatcher,
        LoggerInterface $logger
    ) {
        $this->projectReferenceRevision = $projectReferenceRevision;

        parent::__construct($taskQueue, $eventDispatcher, $logger);
    }

    public function getProjectReferenceRevision()
    {
        return $this->projectReferenceRevision;
    }

    public function getProjectReference()
    {
        return $this->getProjectReferenceRevision()->getReference();
    }

    public function getProject()
    {
        return $this->getProjectReference()->getProject();
    }
}
