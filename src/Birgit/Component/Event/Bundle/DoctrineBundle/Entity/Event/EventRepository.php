<?php

namespace Birgit\Component\Event\Bundle\DoctrineBundle\Entity\Event;

use Birgit\Component\Event\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Component\Event\Model\Event\EventRepositoryInterface;
use Birgit\Component\Event\Exception\NotFoundException;

/**
 * Event Repository
 */
class EventRepository extends EntityRepository implements EventRepositoryInterface
{
    public function create()
    {
        $event = $this->createEntity();

        return $event;
    }

    public function save(Event $event)
    {
        $this->saveEntity($event);
    }

    public function get($id)
    {
        $event = $this->findOneById($id);

        if (!$event) {
            throw new NotFoundException();
        }

        return $event;
    }

    public function delete(Event $event)
    {
        $this->deleteEntity($event);
    }
}
