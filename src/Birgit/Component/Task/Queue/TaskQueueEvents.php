<?php

namespace Birgit\Component\Task\Queue;

/**
 * Task queue events
 */
final class TaskQueueEvents
{
    const RUN_START = 'birgit.task_queue.run_start';
    const RUN_END   = 'birgit.task_queue.run_end';
}
