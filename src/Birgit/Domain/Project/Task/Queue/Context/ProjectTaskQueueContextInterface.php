<?php

namespace Birgit\Domain\Project\Task\Queue\Context;

use Birgit\Domain\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Model\Project\Project;

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
