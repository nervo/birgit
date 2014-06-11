<?php

namespace Birgit\Core\Task\Queue\Context\Project\Reference\Revision;

use Birgit\Core\Model\Project\Reference\Revision\ProjectReferenceRevision;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;

/**
 * Project reference revision Task queue Context
 */
class ProjectReferenceRevisionTaskQueueContext extends ProjectReferenceTaskQueueContext implements ProjectReferenceRevisionTaskQueueContextInterface
{
    protected $projectReferenceRevision;

    public function __construct(
        ProjectReferenceRevision $projectReferenceRevision,
        TaskQueueContextInterface $context
    ) {
        $this->projectReferenceRevision = $projectReferenceRevision;

        parent::__construct(
            $projectReferenceRevision->getReference(),
            $context
        );
    }

    public function getProjectReferenceRevision()
    {
        return $this->projectReferenceRevision;
    }
}
