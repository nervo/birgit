<?php

namespace Birgit\Domain\Project\Task\Handler;

use Birgit\Domain\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Model\Task\Task;
use Birgit\Model\Task\Queue\TaskQueue;
use Birgit\Model\Project\Reference\ProjectReference;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContextInterface;
use Birgit\Domain\Exception\Context\ContextException;
use Birgit\Domain\Task\Handler\TaskHandler;
use Birgit\Domain\Exception\Task\Queue\SuspendTaskQueueException;

/**
 * Project reference Task handler
 */
class ProjectReferenceTaskHandler extends TaskHandler
{
    /**
     * {@inheritdoc}
     */
    public function getType()
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
            throw new ContextException();
        }

        // Get project reference
        $projectReference = $context->getProjectReference();

        $this->runProjectReferenceHosts(
            $projectReference,
            $context->getTaskQueue()
        );

        // Get project handler
        $projectHandler = $this->handlerManager
            ->getProjectHandler(
                $projectReference->getProject()
            );

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
            $projectReferenceRevisionRepository =  $this->modelManager
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
