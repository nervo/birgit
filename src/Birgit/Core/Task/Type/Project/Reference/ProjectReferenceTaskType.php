<?php

namespace Birgit\Core\Task\Type\Project\Reference;

use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Core\Model\Project\Reference\ProjectReference;
use Birgit\Core\Task\Queue\Context\Project\Reference\ProjectReferenceTaskQueueContextInterface;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;
use Birgit\Core\Task\Type\TaskType;
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

    protected function runProjectReferenceHosts(ProjectReference $projectReference, TaskQueueContextInterface $context)
    {
        $suspend = false;

        // Find hosts to delete
        foreach ($projectReference->getHosts() as $host) {
            if (!$host->getProjectEnvironment()->matchReference($projectReference)) {

                $taskQueue = $context->getTaskManager()
                    ->createProjectReferenceTaskQueue($projectReference, [
                        'host_delete' => [
                            'project_environment_name' => $host->getProjectEnvironment()->getName()
                        ]
                    ]);

                $context->getTaskQueue()
                    ->addPredecessor($taskQueue);

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

                $taskQueue = $context->getTaskManager()
                    ->createProjectReferenceTaskQueue($projectReference, [
                        'host_create' => [
                            'project_environment_name' => $projectEnvironment->getName()
                        ]
                    ]);

                $context->getTaskQueue()
                    ->addPredecessor($taskQueue);

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
            $context
        );

        // Get project handler
        $projectHandler = $this->projectManager
            ->handleProject($projectReference->getProject(), $context);

        // Get "real life" project reference revision
        $projectHandlerReferenceRevisionName = $projectHandler->getReferenceRevision(
            $projectReference
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

        $taskQueue = $context->getTaskManager()
            ->createProjectReferenceRevisionTaskQueue($projectReferenceRevision, [
                'project_reference_revision'
            ]);

        $context->getTaskQueue()
            ->addSuccessor($taskQueue);
    }
}
