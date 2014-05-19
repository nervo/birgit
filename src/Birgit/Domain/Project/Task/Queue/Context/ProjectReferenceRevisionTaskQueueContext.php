<?php

namespace Birgit\Domain\Project\Task\Queue\Context;

use Psr\Log\LoggerInterface;

use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\Project\Reference\Revision\ProjectReferenceRevision;

/**
 * Project reference revision Task queue Context
 */
class ProjectReferenceRevisionTaskQueueContext extends TaskQueueContext implements ProjectReferenceRevisionTaskQueueContextInterface
{
    protected $projectReferenceRevision;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(ProjectReferenceRevision $projectReferenceRevision, TaskQueue $queue, LoggerInterface $logger)
    {
        $this->projectReferenceRevision = $projectReferenceRevision;

        parent::__construct($queue, $logger);
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
