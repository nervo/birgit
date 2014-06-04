<?php

namespace Birgit\Core\Bundle\DoctrineBundle\Entity\Project\Reference;

use Birgit\Core\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Core\Model\Project\Reference\ProjectReferenceRepositoryInterface;
use Birgit\Core\Bundle\DoctrineBundle\Entity\Project\Project;
use Birgit\Core\Exception\Model\ModelNotFoundException;

/**
 * Project reference Repository
 */
class ProjectReferenceRepository extends EntityRepository implements ProjectReferenceRepositoryInterface
{
    public function create($name, Project $project)
    {
        $projectReference = $this->createEntity();

        $projectReference
            ->setName((string) $name);

        $project->addReference($projectReference);

        return $projectReference;
    }

    public function save(ProjectReference $projectReference)
    {
        $this->saveEntity($projectReference);
    }

    public function get($name, Project $project)
    {
        $projectReference = $this->findOneBy(array(
            'name'    => $name,
            'project' => $project
        ));

        if (!$projectReference) {
            throw new ModelNotFoundException();
        }

        return $projectReference;
    }
}
