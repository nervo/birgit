<?php

namespace Birgit\Base\Local\Task\Type\Host;

use Symfony\Component\Filesystem\Filesystem;

use Birgit\Core\Task\Type\TaskType;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Core\Task\Queue\Context\Host\HostTaskQueueContextInterface;
use Birgit\Component\Task\Queue\Exception\ContextTaskQueueException;

/**
 * Host - Task Type
 */
class WorkspaceHostTaskType extends TaskType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'host_workspace_local';
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

        // Get workspace
        $workspace = $this->projectManager
            ->handleProjectEnvironment($host->getProjectEnvironment())
            ->getWorkspace($context);

        // Local
        $local =
            $workspace .
            DIRECTORY_SEPARATOR .
            $host->getProjectEnvironment()->getProject()->getName() .
            DIRECTORY_SEPARATOR .
            $host->getProjectEnvironment()->getName() .
            DIRECTORY_SEPARATOR .
            $host->getProjectReference()->getName();

        $fileSystem = new Filesystem();

        if (!$fileSystem->exists($local)) {
            $fileSystem->mkdir($local);
        }
    }
}
