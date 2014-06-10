<?php

namespace Birgit\Component\Event\Bundle\DoctrineBundle\Entity\Event\Dispatcher;

use Birgit\Component\Event\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Component\Event\Model\Event\EventRepositoryInterface;
use Birgit\Component\Event\Exception\NotFoundException;

/**
 * Event Dispatcher Repository
 */
class EventDispatcherRepository extends EntityRepository implements EventRepositoryInterface
{
    public function create()
    {
        $eventDispatcher = $this->createEntity();

        return $eventDispatcher;
    }

    public function save(EventDispatcher $eventDispatcher)
    {
        $this->saveEntity($eventDispatcher);
    }

    public function refresh(EventDispatcher $eventDispatcher)
    {
        $this->refreshEntity($eventDispatcher);
    }

    public function get($id)
    {
        $eventDispatcher = $this->findOneById($id);

        if (!$eventDispatcher) {
            throw new NotFoundException();
        }

        return $eventDispatcher;
    }

    public function delete(EventDispatcher $eventDispatcher)
    {
        $this->deleteEntity($eventDispatcher);
    }
}
