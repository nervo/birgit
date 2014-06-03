<?php

namespace Birgit\Domain\Task\Handler\Build;

use Birgit\Component\Task\Handler\TaskHandler;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Model\Task\Task;
use Birgit\Component\Context\Exception\ContextException;
use Birgit\Domain\Task\Queue\Context\HostTaskQueueContextInterface;

/**
 * Build - Create Task Handler
 */
class BuildCreateTaskHandler extends TaskHandler
{
    /**
     * {@inheritdoc}
     */
    public function getType()
    {
        return 'build_create';
    }

    /**
     * {@inheritdoc}
     */
    public function run(Task $task, TaskQueueContextInterface $context)
    {
        if (!$context instanceof HostTaskQueueContextInterface) {
            throw new ContextException();
        }

        // Get host
        $host = $context->getHost();

        // Get project reference revision
        $projectReferenceRevision = $this->modelManager
            ->getProjectReferenceRevisionRepository()
            ->get(
                $task->getHandlerDefinition()->getParameters()->get('project_reference_revision_name'),
                $host->getProjectReference()
            );

        // Get build repository
        $buildRepository =  $this->modelManager
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
        $taskQueue = $this->taskManager
            ->createBuildTaskQueue($build);

        $this->taskManager->pushTaskQueue($taskQueue);
    }
}
