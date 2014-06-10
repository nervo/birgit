<?php

namespace Birgit\Component\Event\Model\Event;

use Birgit\Component\Event\Distant\DistantEvent;

/**
 * Event
 */
abstract class Event
{
    /**
     * Get name
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Set event
     *
     * @param DistantEvent $event
     *
     * @return Event
     */
    abstract public function setEvent(DistantEvent $event);

    /**
     * Get event
     *
     * @return DistantEvent
     */
    abstract public function getEvent();
}
