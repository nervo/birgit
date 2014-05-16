<?php

namespace Birgit\Domain\Task\Queue\Handler;

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
