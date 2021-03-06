<?php

namespace Birgit\Core\Bundle\DoctrineBundle\Entity\Project;

use Birgit\Core\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Core\Model\Project\ProjectRepositoryInterface;
use Birgit\Core\Exception\Model\ModelNotFoundException;
use Birgit\Component\Type\TypeDefinition;

/**
 * Project Repository
 */
class ProjectRepository extends EntityRepository implements ProjectRepositoryInterface
{
    public function create($name, TypeDefinition $typeDefinition)
    {
        $project = $this->createEntity();

        $project
            ->setName((string) $name)
            ->setTypeDefinition($typeDefinition);

        return $project;
    }

    public function save(Project $project)
    {
        $this->saveEntity($project);
    }

    public function get($name)
    {
        $project = $this->findOneByName($name);

        if (!$project) {
            throw new ModelNotFoundException();
        }

        return $project;
    }
}
