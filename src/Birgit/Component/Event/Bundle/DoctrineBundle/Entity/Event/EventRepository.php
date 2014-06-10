<?php

namespace Birgit\Component\Event\Bundle\DoctrineBundle\Entity\Event;

use Symfony\Component\EventDispatcher\Event as BaseEvent;

use Birgit\Component\Event\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Component\Event\Model\Event\EventRepositoryInterface;
use Birgit\Component\Event\Exception\NotFoundException;
use Birgit\Component\Event\Distant\DistantEvent;

/**
 * Event Repository
 */
class EventRepository extends EntityRepository implements EventRepositoryInterface
{
    public function create($name, BaseEvent $event = null)
    {
        $entity = $this->createEntity();

        $entity
            ->setName((string) $name);

        if ($event instanceof DistantEvent) {
            $entity
                ->setEvent($event);
        }

        return $entity;
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
