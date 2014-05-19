<?php

namespace Birgit\Domain\Project\Task\Queue\Context;

use Birgit\Model\Project\Reference\Revision\ProjectReferenceRevision;

/**
 * Project reference revision Task queue Context Interface
 */
interface ProjectReferenceRevisionTaskQueueContextInterface extends ProjectReferenceTaskQueueContextInterface
{
    /**
     * Get project reference revision
     *
     * @return ProjectReferenceRevision
     */
    public function getProjectReferenceRevision();
}
