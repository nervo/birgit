<?php

namespace Birgit\Core\Task\Type\Build;

use Birgit\Core\Task\Type\TaskType;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;
use Birgit\Core\Task\Queue\Context\Host\HostTaskQueueContextInterface;

/**
 * Build - Create Task Type
 */
class BuildCreateTaskType extends TaskType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'build_create';
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
        $projectReferenceRevision = $this->modelRepositoryManager
            ->getProjectReferenceRevisionRepository()
            ->get(
                $task->getTypeDefinition()->getParameter('project_reference_revision_name'),
                $host->getProjectReference()
            );

        // Get build repository
        $buildRepository =  $this->modelRepositoryManager
            ->getBuildRepository();

        // Create build
        $build = $buildRepository
            ->create(
                $host,
                $projectReferenceRevision
            );

        // Save build
        $buildRepository->save($build);

        // Build task queue
        $taskQueue = $context->getTaskManager()
            ->createBuildTaskQueue($build);

        $context->getTaskManager()->pushTaskQueue($taskQueue);
    }
}
