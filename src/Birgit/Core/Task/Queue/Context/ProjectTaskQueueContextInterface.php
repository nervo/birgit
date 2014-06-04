<?php

namespace Birgit\Core\Task\Queue\Context;

use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Core\Model\Project\Project;

/**
 * Project Task queue Context Interface
 */
interface ProjectTaskQueueContextInterface extends TaskQueueContextInterface
{
    /**
     * Get project
     *
     * @return Project
     */
    public function getProject();
}
