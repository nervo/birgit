<?php

namespace Birgit\Domain\Project\Task\Queue\Context;

use Birgit\Model\Project\Environment\ProjectEnvironment;

/**
 * Project environment Task queue Context Interface
 */
interface ProjectEnvironmentTaskQueueContextInterface extends ProjectTaskQueueContextInterface
{
    /**
     * Get project environment
     *
     * @return ProjectEnvironment
     */
    public function getProjectEnvironment();
}
