<?php

namespace Birgit\Component\Event;

use Symfony\Component\EventDispatcher\EventDispatcher as BaseEventDispatcher;
use Symfony\Component\EventDispatcher\Event;

use Birgit\Component\Event\Distant\DistantEvent;
use Birgit\Component\Event\Model\Event\EventRepositoryInterface;
use Birgit\Component\Event\Bundle\DoctrineBundle\Entity\Event\Dispatcher\EventDispatcherRepository;

/**
 * Event Dispatcher
 */
class EventDispatcher extends BaseEventDispatcher
{
    protected $eventRepository;
    protected $eventDispatcherRepository;
    protected $eventDispatcherModel;

    public function __construct(
        EventRepositoryInterface $eventRepository,
        EventDispatcherRepository $eventDispatcherRepository
    ) {
        $this->eventRepository = $eventRepository;
        $this->eventDispatcherRepository = $eventDispatcherRepository;

        $this->eventDispatcherModel = $this->eventDispatcherRepository
            ->create();

        $this->eventDispatcherRepository
            ->save($this->eventDispatcherModel);
    }

    public function __destruct()
    {
        $this->eventDispatcherRepository
            ->delete($this->eventDispatcherModel);
    }

    public function dispatch($eventName, Event $event = null)
    {
        if (!$event instanceof DistantEvent) {
            return parent::dispatch($eventName, $event);
        }

        $eventModel = $this->eventRepository
            ->create($eventName, $event);

        $this->eventRepository
            ->save($eventModel);

        foreach ($this->eventDispatcherRepository->all() as $eventDispatcherModel) {
            $eventDispatcherModel->addEvent($eventModel);
            $this->eventDispatcherRepository
                ->save($eventDispatcherModel);
        }

        return $event;
    }

    public function check()
    {
        $this->eventDispatcherRepository
            ->refresh($this->eventDispatcherModel);

        $events = $this->eventDispatcherModel->getEvents();

        foreach ($events as $event) {

            parent::dispatch(
                $event->getName(),
                $event->getEvent()
            );

            $this->eventDispatcherModel
                ->removeEvent($event);
            $this->eventDispatcherRepository
                ->save($this->eventDispatcherModel);
        }
    }
}
