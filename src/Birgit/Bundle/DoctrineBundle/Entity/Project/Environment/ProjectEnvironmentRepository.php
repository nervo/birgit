<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Project\Environment;

use Birgit\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Model\Project\Environment\ProjectEnvironmentRepositoryInterface;
use Birgit\Bundle\DoctrineBundle\Entity\Project\Project;
use Birgit\Domain\Exception\Model\ModelNotFoundException;
use Birgit\Domain\Handler\HandlerDefinition;

/**
 * Project environment Repository
 */
class ProjectEnvironmentRepository extends EntityRepository implements ProjectEnvironmentRepositoryInterface
{
    public function create($name, Project $project, HandlerDefinition $handlerDefinition)
    {
        $projectEnvironment = $this->createEntity();

        $projectEnvironment
            ->setName((string) $name)
            ->setHandlerDefinition($handlerDefinition);

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
