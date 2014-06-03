<?php

namespace Birgit\Component\Task\Queue\Context;

use Birgit\Component\Context\ContextInterface;

/**
 * Task queue Context Interface
 */
interface TaskQueueContextInterface extends ContextInterface
{
    public function getTaskQueue();
}
