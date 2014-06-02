<?php

namespace Birgit\Domain\Build\Task\Queue\Handler;

use Birgit\Domain\Task\Queue\Handler\TaskQueueHandler;
use Birgit\Domain\Context\ContextInterface;
use Birgit\Model\Task\Queue\TaskQueue;

/**
 *Build Task queue Context
 */
class BuildTaskQueueHandler extends TaskQueueHandler
{
    public function getType()
    {
        return 'build';
    }
}
