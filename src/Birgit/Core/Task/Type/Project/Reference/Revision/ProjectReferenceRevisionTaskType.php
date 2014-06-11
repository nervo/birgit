<?php

namespace Birgit\Core\Task\Type\Project\Reference\Revision;

use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;
use Birgit\Core\Task\Type\TaskType;
use Birgit\Core\Task\Queue\Context\Project\Reference\Revision\ProjectReferenceRevisionTaskQueueContextInterface;

/**
 * Project reference revision Task type
 */
class ProjectReferenceRevisionTaskType extends TaskType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'project_reference_revision';
    }

    /**
     * {@inheritdoc}
     */
    public function run(Task $task, TaskQueueContextInterface $context)
    {
        if (!$context instanceof ProjectReferenceRevisionTaskQueueContextInterface) {
            throw new ContextTaskQueueException();
        }

        // Get project reference revision
        $projectReferenceRevision = $context->getProjectReferenceRevision();

        foreach ($projectReferenceRevision->getReference()->getHosts() as $host) {
            $buildFound = false;
            foreach ($host->getBuilds() as $build) {
                if ($build->getProjectReferenceRevision() === $projectReferenceRevision) {
                    $buildFound = true;
                    break;
                }
            }

            if (!$buildFound) {
                $taskQueue = $context->getTaskManager()
                    ->createHostTaskQueue($host, [
                        'build_create' => [
                            'project_reference_revision_name' => $projectReferenceRevision->getName()
                        ]
                    ]);

                $context->getTaskQueue()
                    ->addSuccessor($taskQueue);
            }
        }
    }
}
