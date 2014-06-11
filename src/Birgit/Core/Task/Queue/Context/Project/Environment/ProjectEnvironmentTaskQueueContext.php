<?php

namespace Birgit\Core\Task\Queue\Context\Project\Environment;

use Birgit\Core\Task\Queue\Context\Project\ProjectTaskQueueContext;
use Birgit\Core\Model\Project\Environment\ProjectEnvironment;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;

/**
 * Project environment Task queue Context
 */
class ProjectEnvironmentTaskQueueContext extends ProjectTaskQueueContext implements ProjectEnvironmentTaskQueueContextInterface
{
    protected $projectEnvironment;

    public function __construct(
        ProjectEnvironment $projectEnvironment,
        TaskQueueContextInterface $context
    ) {
        $this->projectEnvironment = $projectEnvironment;

        parent::__construct(
            $projectEnvironment->getProject(),
            $context
        );
    }

    public function getProjectEnvironment()
    {
        return $this->projectEnvironment;
    }
}
