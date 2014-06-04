<?php

namespace Birgit\Core\Task\Queue\Handler\Cron;

use Birgit\Component\Task\Queue\Handler\TaskQueueHandler;

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
