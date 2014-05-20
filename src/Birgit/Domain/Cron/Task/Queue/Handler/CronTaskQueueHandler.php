<?php

namespace Birgit\Domain\Cron\Task\Queue\Handler;

use Birgit\Domain\Task\Queue\Handler\TaskQueueHandler;

/**
 * Cron Task queue Handler
 */
class CronTaskQueueHandler extends TaskQueueHandler
{
    public function getType()
    {
        return 'cron';
    }
}
