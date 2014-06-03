<?php

namespace Birgit\Domain\Task\Queue\Context;

use Birgit\Component\Task\Queue\Context\TaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\Project\Reference\Revision\ProjectReferenceRevision;
use Birgit\Domain\Context\ContextInterface;

/**
 * Project reference revision Task queue Context
 */
class ProjectReferenceRevisionTaskQueueContext extends TaskQueueContext implements ProjectReferenceRevisionTaskQueueContextInterface
{
    protected $projectReferenceRevision;

    public function __construct(
        ProjectReferenceRevision $projectReferenceRevision,
        TaskQueue $queue,
        ContextInterface $context
    ) {
        $this->projectReferenceRevision = $projectReferenceRevision;

        parent::__construct($queue, $context);
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
