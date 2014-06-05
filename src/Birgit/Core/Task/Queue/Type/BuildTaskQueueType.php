<?php

namespace Birgit\Core\Task\Queue\Type;

use Birgit\Component\Task\Queue\Type\TaskQueueType;

/**
 *Build Task queue Context
 */
class BuildTaskQueueType extends TaskQueueType
{
    public function getAlias()
    {
        return 'build';
    }
}
