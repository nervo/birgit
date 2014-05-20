<?php

namespace Birgit\Bundle\CoreBundle\Entity\Host;

use Birgit\Bundle\CoreBundle\Entity\EntityRepository;
use Birgit\Model\Host\HostRepositoryInterface;
use Birgit\Bundle\CoreBundle\Entity\Host\Host;
use Birgit\Bundle\CoreBundle\Entity\Project\Reference\ProjectReference;
use Birgit\Bundle\CoreBundle\Entity\Project\Environment\ProjectEnvironment;

/**
 * Host Repository
 */
class HostRepository extends EntityRepository implements HostRepositoryInterface
{
    public function create(ProjectReference $projectReference, ProjectEnvironment $projectEnvironment)
    {
        $host = new Host();

        $projectReference->addHost($host);
        $projectEnvironment->addHost($host);
        
        return $host;
    }

    public function save(Host $host)
    {
        $entityManager = $this->getEntityManager();
        
        $entityManager->persist($host);
        $entityManager->flush($host);
    }
    
    public function findOneByProjectReferenceAndProjectEnvironment(ProjectReference $projectReference, ProjectEnvironment $projectEnvironment)
    {
        return $this->findOneBy(array(
            'projectReference'   => $projectReference,
            'projectEnvironment' => $projectEnvironment
        ));
    }
}
