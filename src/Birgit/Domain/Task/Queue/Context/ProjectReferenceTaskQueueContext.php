<?php

namespace Birgit\Domain\Task\Queue\Context;

use Birgit\Component\Task\Queue\Context\TaskQueueContext;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\Project\Reference\ProjectReference;
use Birgit\Domain\Context\ContextInterface;

/**
 * Project reference Task queue Context
 */
class ProjectReferenceTaskQueueContext extends TaskQueueContext implements ProjectReferenceTaskQueueContextInterface
{
    protected $projectReference;

    public function __construct(
        ProjectReference $projectReference,
        TaskQueue $taskQueue,
        ContextInterface $context
    ) {
        $this->projectReference = $projectReference;

        parent::__construct($taskQueue, $context);
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
