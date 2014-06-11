<?php

namespace Birgit\Component\Task\Queue;

/**
 * Task queue events
 */
final class TaskQueueEvents
{
    const CREATE    = 'birgit.task_queue.create';
    const UPDATE    = 'birgit.task_queue.update';
    const TASK_ADD  = 'birgit.task_queue.task_add';

    const RUN_START = 'birgit.task_queue.run_start';
    const RUN_END   = 'birgit.task_queue.run_end';
}
