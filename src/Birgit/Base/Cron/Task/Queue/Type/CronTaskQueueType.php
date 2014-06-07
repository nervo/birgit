<?php

namespace Birgit\Base\Cron\Task\Queue\Type;

use Birgit\Core\Task\Queue\Type\TaskQueueType;

/**
 * Cron Task queue Type
 */
class CronTaskQueueType extends TaskQueueType
{
    public function getAlias()
    {
        return 'cron';
    }
}
