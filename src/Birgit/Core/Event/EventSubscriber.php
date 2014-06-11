<?php

namespace Birgit\Core\Event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Birgit\Component\Event\EventDispatcher;
use Birgit\Component\Event\Distant\DistantEvent;
use Birgit\Component\Task\Event\TaskEvent;
use Birgit\Component\Task\Queue\TaskQueueEvents;
use Birgit\Component\Task\Queue\Event\TaskQueueEvent;

/**
 * Event Subscriber
 */
class EventSubscriber implements EventSubscriberInterface
{
    /**
     * Distant event dispatcher
     * 
     * @var type
     */
    public $distantEventDispatcher;

    /**
     * Constructor
     *
     * @param EventDispatcher $eventDispatcher
     */
    public function __construct(EventDispatcher $eventDispatcher)
    {
        // Distant event dispatcher
        $this->distantEventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            TaskQueueEvents::CREATE   => 'onTaskQueueEvent',
            TaskQueueEvents::UPDATE   => 'onTaskQueueEvent',
            TaskQueueEvents::TASK_ADD => 'onTaskQueueTaskEvent'
        );
    }

    /**
     * On task queue event
     *
     * @param TaskQueueEvent $event
     * @param string         $eventName
     */
    public function onTaskQueueEvent(TaskQueueEvent $event, $eventName)
    {
        // Get task queue
        $taskQueue = $event->getTaskQueue();

        // Distant dispatch
        $this->distantEventDispatcher
            ->dispatch(
                $eventName,
                new DistantEvent(array(
                    'taskQueue' => $taskQueue->normalize()
                ))
            );
    }

    /**
     * On task queue task event
     *
     * @param TaskEvent $event
     * @param string    $eventName
     */
    public function onTaskQueueTaskEvent(TaskEvent $event, $eventName)
    {
        // Get task
        $task = $event->getTask();

       // Distant dispatch
        $this->distantEventDispatcher
            ->dispatch(
                $eventName,
                new DistantEvent(array(
                    'taskQueue' => $task->getQueue()->normalize(),
                    'task'      => $task->normalize()
                ))
            );
    }
}
