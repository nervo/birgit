<?php

namespace Birgit\Component\Event\Bundle\DoctrineBundle\Entity\Event;

use Birgit\Component\Event\Model;
use Birgit\Component\Event\Distant\DistantEvent;

/**
 * Event
 */
class Event extends Model\Event\Event
{
    /**
     * Id
     *
     * @var string
     */
    private $id;

    /**
     * Name
     *
     * @var string
     */
    private $name;

    /**
     * Parameters
     *
     * @var array
     */
    private $parameters = array();

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
     * Set name
     *
     * @param string $name
     *
     * @return Event
     */
    public function setName($name)
    {
        return $this->name = (string) $name;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setEvent(DistantEvent $event)
    {
        $this->parameters = $event->getParameters();

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEvent()
    {
        if (!$this->parameters) {
            return null;
        }
        
        return new DistantEvent(
            $this->parameters
        );
    }
}
