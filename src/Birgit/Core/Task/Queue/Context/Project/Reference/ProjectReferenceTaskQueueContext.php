<?php

namespace Birgit\Core\Task\Queue\Context\Project\Reference;

use Birgit\Core\Model\Project\Reference\ProjectReference;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;

/**
 * Project reference Task queue Context
 */
class ProjectReferenceTaskQueueContext extends ProjectTaskQueueContext implements ProjectReferenceTaskQueueContextInterface
{
    protected $projectReference;

    public function __construct(
        ProjectReference $projectReference,
        TaskQueueContextInterface $context
    ) {
        $this->projectReference = $projectReference;

        parent::__construct(
            $projectReference->getProject(),
            $context
        );
    }

    public function getProjectReference()
    {
        return $this->projectReference;
    }
}
