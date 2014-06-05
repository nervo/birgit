<?php

namespace Birgit\Core\Task\Type\Project;

use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;
use Birgit\Core\Model\Project\Reference\ProjectReference;
use Birgit\Core\Task\Queue\Context\ProjectReferenceTaskQueueContextInterface;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;
use Birgit\Component\Task\Type\TaskType;
use Birgit\Component\Task\Queue\Exception\SuspendTaskQueueException;

/**
 * Project reference Task type
 */
class ProjectReferenceTaskType extends TaskType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'project_reference';
    }

    protected function runProjectReferenceHosts(ProjectReference $projectReference, TaskQueue $taskQueue)
    {
        $suspend = false;

        // Find hosts to delete
        foreach ($projectReference->getHosts() as $host) {
            if (!$host->getProjectEnvironment()->matchReference($projectReference)) {

                $taskQueueChild = $this->taskManager
                    ->createProjectReferenceTaskQueue($projectReference, [
                        'host_delete' => [
                            'project_environment_name' => $host->getProjectEnvironment()->getName()
                        ]
                    ]);

                $taskQueue
                    ->addChild($taskQueueChild);

                $this->taskManager->pushTaskQueue($taskQueueChild);

                $suspend = true;
            }
        }

        // Find hosts
        foreach ($projectReference->getProject()->getEnvironments() as $projectEnvironment) {
            $hostFound = false;
            foreach ($projectReference->getHosts() as $host) {
                if ($host->getProjectEnvironment() === $projectEnvironment) {
                    $hostFound = true;
                    break;
                }
            }

            if (!$hostFound && $projectEnvironment->matchReference($projectReference)) {

                $taskQueueChild = $this->taskManager
                    ->createProjectReferenceTaskQueue($projectReference, [
                        'host_create' => [
                            'project_environment_name' => $projectEnvironment->getName()
                        ]
                    ]);

                $taskQueue
                    ->addChild($taskQueueChild);

                $this->taskManager->pushTaskQueue($taskQueueChild);

                $suspend = true;
            }
        }

        if ($suspend) {
            throw new SuspendTaskQueueException();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function run(Task $task, TaskQueueContextInterface $context)
    {
        if (!$context instanceof ProjectReferenceTaskQueueContextInterface) {
            throw new ContextTaskQueueException();
        }

        // Get project reference
        $projectReference = $context->getProjectReference();

        $this->runProjectReferenceHosts(
            $projectReference,
            $context->getTaskQueue()
        );

        // Get project handler
        $projectHandler = $this->projectManager
            ->handleProject($projectReference->getProject(), $context);

        // Get "real life" project reference revision
        $projectHandlerReferenceRevisionName = $projectHandler->getReferenceRevision(
            $projectReference,
            $context
        );

        // Find project reference revisions
        $projectReferenceRevisionFound = false;
        foreach ($projectReference->getRevisions() as $projectReferenceRevision) {
            if ($projectReferenceRevision->getName() === $projectHandlerReferenceRevisionName) {
                $projectReferenceRevisionFound = true;
                break;
            }
        }

        if (!$projectReferenceRevisionFound) {
            // Get project reference revision repository
            $projectReferenceRevisionRepository =  $this->modelRepositoryManager
                ->getProjectReferenceRevisionRepository();

            // Create
            $projectReferenceRevision = $projectReferenceRevisionRepository
                ->create(
                    $projectHandlerReferenceRevisionName,
                    $projectReference
                );

            // Save
            $projectReferenceRevisionRepository->save($projectReferenceRevision);
        }

        $taskQueue = $this->taskManager
            ->createProjectReferenceRevisionTaskQueue($projectReferenceRevision, [
                'project_reference_revision'
            ]);

        $this->taskManager->pushTaskQueue($taskQueue);
    }
}
