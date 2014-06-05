<?php

namespace Birgit\Core\Task\Type\Project;

use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;
use Birgit\Component\Task\Type\TaskType;
use Birgit\Core\Task\Queue\Context\ProjectReferenceRevisionTaskQueueContextInterface;

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
                $taskQueue = $this->taskManager
                    ->createHostTaskQueue($host, [
                        'build_create' => [
                            'project_reference_revision_name' => $projectReferenceRevision->getName()
                        ]
                    ]);

                $this->taskManager->pushTaskQueue($taskQueue);
            }
        }
    }
}
