<?php

namespace Birgit\Core\Task\Queue\Context\Project\Reference\Revision;

use Birgit\Core\Task\Queue\Context\Project\Reference\ProjectReferenceTaskQueueContextInterface;
use Birgit\Core\Model\Project\Reference\Revision\ProjectReferenceRevision;

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
