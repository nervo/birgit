<?php

namespace Birgit\Component\Event\Bundle\DoctrineBundle\Entity\Event;

use Birgit\Component\Event\Model;

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
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }
}
