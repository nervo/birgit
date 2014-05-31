<?php

namespace Birgit\Domain\Project\Task\Handler;

use Birgit\Domain\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Model\Task\Task;
use Birgit\Domain\Exception\Context\ContextException;
use Birgit\Domain\Task\Handler\TaskHandler;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceRevisionTaskQueueContextInterface;

/**
 * Project reference revision Task handler
 */
class ProjectReferenceRevisionTaskHandler extends TaskHandler
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'project_reference_revision';
    }

    /**
     * {@inheritdoc}
     */
    public function run(Task $task, TaskQueueContextInterface $context)
    {
        if (!$context instanceof ProjectReferenceRevisionTaskQueueContextInterface) {
            throw new ContextException();
        }

        // Get project reference revision
        $projectReferenceRevision = $context->getProjectReferenceRevision();
    }
}
