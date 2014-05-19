<?php

namespace Birgit\Domain\Project\Task\Queue\Context;

use Psr\Log\LoggerInterface;

use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\Project\Project;

/**
 * Project Task queue Context
 */
class ProjectTaskQueueContext extends TaskQueueContext implements ProjectTaskQueueContextInterface
{
    protected $project;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(Project $project, TaskQueue $queue, LoggerInterface $logger)
    {
        $this->project = $project;

        parent::__construct($queue, $logger);
    }

    public function getProject()
    {
        return $this->project;
    }
}
