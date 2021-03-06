<?php

namespace Birgit\Component\Task\Queue;

/**
 * Task queue events
 */
final class TaskQueueEvents
{
    const CREATE          = 'birgit.task_queue.create';
    const UPDATE          = 'birgit.task_queue.update';
    const TASK_ADD        = 'birgit.task_queue.task_add';
    const SUCCESSOR_ADD   = 'birgit.task_queue.successor_add';
    const PREDECESSOR_ADD = 'birgit.task_queue.predecessor_add';
}
