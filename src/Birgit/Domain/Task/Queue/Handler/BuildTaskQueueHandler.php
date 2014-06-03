<?php

namespace Birgit\Domain\Task\Queue\Handler;

use Birgit\Component\Task\Queue\Handler\TaskQueueHandler;

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
