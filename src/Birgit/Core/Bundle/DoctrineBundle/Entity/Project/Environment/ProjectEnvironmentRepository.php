<?php

namespace Birgit\Core\Bundle\DoctrineBundle\Entity\Project\Environment;

use Birgit\Core\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Core\Model\Project\Environment\ProjectEnvironmentRepositoryInterface;
use Birgit\Core\Bundle\DoctrineBundle\Entity\Project\Project;
use Birgit\Core\Exception\Model\ModelNotFoundException;
use Birgit\Component\Type\TypeDefinition;

/**
 * Project environment Repository
 */
class ProjectEnvironmentRepository extends EntityRepository implements ProjectEnvironmentRepositoryInterface
{
    public function create($name, Project $project, TypeDefinition $typeDefinition)
    {
        $projectEnvironment = $this->createEntity();

        $projectEnvironment
            ->setName((string) $name)
            ->setTypeDefinition($typeDefinition);

        $project->addEnvironment($projectEnvironment);

        return $projectEnvironment;
    }

    public function save(ProjectEnvironment $projectEnvironment)
    {
        $this->saveEntity($projectEnvironment);
    }

    public function get($name, Project $project)
    {
        $projectEnvironment = $this->findOneBy(array(
            'name'    => $name,
            'project' => $project
        ));

        if (!$projectEnvironment) {
            throw new ModelNotFoundException();
        }

        return $projectEnvironment;
    }
}
