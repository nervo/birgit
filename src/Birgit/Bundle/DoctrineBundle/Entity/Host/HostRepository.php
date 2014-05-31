<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Host;

use Birgit\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Model\Host\HostRepositoryInterface;
use Birgit\Bundle\DoctrineBundle\Entity\Project\Reference\ProjectReference;
use Birgit\Bundle\DoctrineBundle\Entity\Project\Environment\ProjectEnvironment;

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

    public function findOneByProjectReferenceAndProjectEnvironment(ProjectReference $projectReference, ProjectEnvironment $projectEnvironment)
    {
        return $this->findOneBy(array(
            'projectReference'   => $projectReference,
            'projectEnvironment' => $projectEnvironment
        ));
    }
}
