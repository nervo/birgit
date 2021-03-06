<?php

namespace Birgit\Core\Task\Queue\Context\Project\Reference;

use Birgit\Core\Task\Queue\Context\Project\ProjectTaskQueueContextInterface;
use Birgit\Core\Model\Project\Reference\ProjectReference;

/**
 * Project reference Task queue Context Interface
 */
interface ProjectReferenceTaskQueueContextInterface extends ProjectTaskQueueContextInterface
{
    /**
     * Get project reference
     *
     * @return ProjectReference
     */
    public function getProjectReference();
}
