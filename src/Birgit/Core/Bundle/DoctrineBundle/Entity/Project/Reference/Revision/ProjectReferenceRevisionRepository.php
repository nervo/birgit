<?php

namespace Birgit\Core\Bundle\DoctrineBundle\Entity\Project\Reference\Revision;

use Birgit\Core\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Core\Model\Project\Reference\Revision\ProjectReferenceRevisionRepositoryInterface;
use Birgit\Core\Bundle\DoctrineBundle\Entity\Project\Reference\ProjectReference;
use Birgit\Core\Exception\Model\ModelNotFoundException;

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

    public function get($name, ProjectReference $projectReference)
    {
        $projectReferenceRevision = $this->findOneBy(array(
            'name'      => $name,
            'reference' => $projectReference
        ));

        if (!$projectReferenceRevision) {
            throw new ModelNotFoundException();
        }

        return $projectReferenceRevision;
    }
}
