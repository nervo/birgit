<?php

namespace Birgit\Domain\Project\Task\Queue\Context;

use Psr\Log\LoggerInterface;

use Birgit\Domain\Task\Queue\Context\TaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\Project\Reference\ProjectReference;

/**
 * Project reference Task queue Context
 */
class ProjectReferenceTaskQueueContext extends TaskQueueContext implements ProjectReferenceTaskQueueContextInterface
{
    protected $projectReference;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    public function __construct(ProjectReference $projectReference, TaskQueue $queue, LoggerInterface $logger)
    {
        $this->projectReference = $projectReference;

        parent::__construct($queue, $logger);
    }

    public function getProjectReference()
    {
        return $this->projectReference;
    }

    public function getProject()
    {
        return $this->getProjectReference()->getProject();
    }
}
