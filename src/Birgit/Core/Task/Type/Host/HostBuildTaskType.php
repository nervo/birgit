<?php

namespace Birgit\Core\Task\Type\Host;

use Birgit\Core\Task\Type\TaskType;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Core\Task\Queue\Context\Host\HostTaskQueueContextInterface;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;

/**
 * Host - Build Task Type
 */
class HostBuildTaskType extends TaskType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'host_build';
    }

    /**
     * {@inheritdoc}
     */
    public function run(Task $task, TaskQueueContextInterface $context)
    {
        if (!$context instanceof HostTaskQueueContextInterface) {
            throw new ContextTaskQueueException();
        }

        // Get host
        $host = $context->getHost();

        // Get project reference revision
        $projectReferenceRevision = $context->getProjectReference()
            ->getRevision();

        // Get build repository
        $buildRepository = $this->modelRepositoryManager
            ->getBuildRepository();

        // Create
        $build = $buildRepository
            ->create(
                $host,
                $projectReferenceRevision
            );

        // Save
        $buildRepository->save($build);
    }
}
