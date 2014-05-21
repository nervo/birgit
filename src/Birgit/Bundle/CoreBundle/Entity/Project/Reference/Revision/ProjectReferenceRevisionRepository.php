<?php

namespace Birgit\Bundle\CoreBundle\Entity\Project\Reference\Revision;

use Birgit\Bundle\CoreBundle\Entity\EntityRepository;
use Birgit\Model\Project\Reference\Revision\ProjectReferenceRevisionRepositoryInterface;
use Birgit\Bundle\CoreBundle\Entity\Project\Reference\ProjectReference;
use Birgit\Bundle\CoreBundle\Entity\Project\Reference\Revision\ProjectReferenceRevision;

/**
 * Project reference revision Repository
 */
class ProjectReferenceRevisionRepository extends EntityRepository implements ProjectReferenceRevisionRepositoryInterface
{
    public function create($name, ProjectReference $projectReference)
    {
        $projectReferenceRevision = $this->createEntity();
        
        $projectReferenceRevision
            ->setName((string) $name);

        $projectReference->addRevision($projectReferenceRevision);
        
        return $projectReferenceRevision;
    }

    public function save(ProjectReferenceRevision $projectReferenceRevision)
    {
        $this->saveEntity($projectReferenceRevision);
    }
    
    public function findOneByProjectReferenceAndName(ProjectReference $projectReference, $name)
    {
        return $this->findOneBy(array(
            'reference' => $projectReference,
            'name'      => $name
        ));
    }
}
