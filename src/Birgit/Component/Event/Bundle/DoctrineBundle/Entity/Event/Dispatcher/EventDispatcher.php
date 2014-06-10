<?php

namespace Birgit\Component\Event\Bundle\DoctrineBundle\Entity\Event\Dispatcher;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Component\Event\Bundle\DoctrineBundle\Entity\Event\Event;

/**
 * Event Dispatcher
 */
class EventDispatcher
{
    /**
     * Id
     *
     * @var string
     */
    private $id;

    /**
     * Events
     *
     * @var ArrayCollection
     */
    private $events;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Events
        $this->events = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function addEvent(Event $event)
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeEvent(Event $event)
    {
        $this->events->removeElement($event);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEvents()
    {
        return $this->events;
    }
}
