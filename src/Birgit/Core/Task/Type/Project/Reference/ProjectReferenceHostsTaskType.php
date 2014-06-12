<?php

namespace Birgit\Core\Task\Type\Project\Reference;

use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Core\Task\Queue\Context\Project\Reference\ProjectReferenceTaskQueueContextInterface;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;
use Birgit\Core\Task\Type\TaskType;

/**
 * Project Reference - Hosts Task type
 */
class ProjectReferenceHostsTaskType extends TaskType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'project_reference_hosts';
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

        // Find hosts to delete
        foreach ($projectReference->getHosts() as $host) {
            if (!$host->getProjectEnvironment()->matchReference($projectReference)) {

                // Push delete task as successor
                $context->getTaskManager()
                    ->handleTaskQueue($context->getTaskQueue())
                    ->pushSuccessor(
                        $context->getTaskManager()
                            ->createProjectReferenceTaskQueue($projectReference, [
                                'host_delete' => [
                                    'project_environment_name' => $host->getProjectEnvironment()->getName()
                                ]
                            ])
                    );
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
                // Get host repository
                $hostRepository = $this->modelRepositoryManager
                    ->getHostRepository();

                // Create
                $host = $hostRepository
                    ->create(
                        $projectReference,
                        $projectEnvironment
                    );

                // Save
                $hostRepository->save($host);

                $hostFound = true;
            }

            if ($hostFound) {
                // Push host task as successor
                $context->getTaskManager()
                    ->handleTaskQueue($context->getTaskQueue())
                    ->pushSuccessor(
                        $context->getTaskManager()
                            ->createHostTaskQueue($host, [
                                'host'
                            ])
                    );
            }
        }
    }
}
