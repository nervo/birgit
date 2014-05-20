<?php

namespace Birgit\Domain\Project\Task\Queue\Context;

use Psr\Log\LoggerInterface;

use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\Project\Environment\ProjectEnvironment;

/**
 * Project environment Task queue Context
 */
class ProjectEnvironmentTaskQueueContext extends TaskQueueContext implements ProjectEnvironmentTaskQueueContextInterface
{
    protected $projectEnvironment;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(ProjectEnvironment $projectEnvironment, TaskQueue $queue, LoggerInterface $logger)
    {
        $this->projectEnvironment = $projectEnvironment;

        parent::__construct($queue, $logger);
    }

    public function getProjectEnvironment()
    {
        return $this->projectEnvironment;
    }

    public function getProject()
    {
        return $this->getProjectEnvironment()->getProject();
    }
}
