<?php

namespace Birgit\Core\Task\Queue\Type\Build;

use Birgit\Core\Task\Queue\Type\TaskQueueType;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Core\Task\Queue\Context\Build\BuildTaskQueueContext;
use Birgit\Component\Task\Model\Task\Queue\TaskQueue;

/**
 *Build Task queue Context
 */
class BuildTaskQueueType extends TaskQueueType
{
    public function getAlias()
    {
        return 'build';
    }

    public function run(TaskQueue $taskQueue, TaskQueueContextInterface $context)
    {
        // Get build
        $build = $this->modelRepositoryManager
            ->getBuildRepository()
            ->get(
                $taskQueue->getTypeDefinition()->getParameter('build_id')
            );

        parent::run(
            $taskQueue,
            new BuildTaskQueueContext(
                $build,
                $context
            )
        );
    }
}
