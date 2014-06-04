<?php

namespace Birgit\Core\Bundle\DoctrineBundle\Entity\Host;

use Birgit\Core\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Core\Model\Host\HostRepositoryInterface;
use Birgit\Core\Bundle\DoctrineBundle\Entity\Project\Reference\ProjectReference;
use Birgit\Core\Bundle\DoctrineBundle\Entity\Project\Environment\ProjectEnvironment;
use Birgit\Core\Exception\Model\ModelNotFoundException;

/**
 * Host Repository
 */
class HostRepository extends EntityRepository implements HostRepositoryInterface
{
    public function create(ProjectReference $projectReference, ProjectEnvironment $projectEnvironment)
    {
        $host = $this->createEntity();

        $projectReference->addHost($host);
        $projectEnvironment->addHost($host);

        return $host;
    }

    public function save(Host $host)
    {
        $this->saveEntity($host);
    }

    public function get($id)
    {
        $host = $this->findOneById($id);

        if (!$host) {
            throw new ModelNotFoundException();
        }

        return $host;
    }
}
