<?php

namespace Birgit\Domain\Project\Task\Queue\Context;

use Birgit\Domain\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Model\Project\Reference\ProjectReference;

/**
 * Project reference Task queue Context !Interface
 */
interface ProjectReferenceTaskQueueContextInterface extends TaskQueueContextInterface
{
    /**
     * Get project reference
     *
     * @return ProjectReference
     */
    public function getProjectReference();
}
