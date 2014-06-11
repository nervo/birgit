<?php

namespace Birgit\Core\Task\Queue\Context\Project\Environment;

use Birgit\Core\Model\Project\Environment\ProjectEnvironment;

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
