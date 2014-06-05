<?php

namespace Birgit\Component\Task\Queue\Context;

/**
 * Task queue Context Interface
 */
interface TaskQueueContextInterface
{
    public function getTaskQueue();

    public function getTaskManager();

    public function getEventDispatcher();

    public function getLogger();
}
