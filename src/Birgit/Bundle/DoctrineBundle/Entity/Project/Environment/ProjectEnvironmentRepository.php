<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Project\Environment;

use Birgit\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Model\Project\Environment\ProjectEnvironmentRepositoryInterface;
use Birgit\Bundle\DoctrineBundle\Entity\Project\Project;
use Birgit\Bundle\DoctrineBundle\Entity\Project\Environment\ProjectEnvironment;
use Birgit\Component\Parameters\Parameters;
use Birgit\Component\Exception\Model\ModelNotFoundException;

/**
 * Project environment Repository
 */
class ProjectEnvironmentRepository extends EntityRepository implements ProjectEnvironmentRepositoryInterface
{
    public function create($name, Project $project, $type, Parameters $parameters = null)
    {
        $projectEnvironment = $this->createEntity();
        
        $projectEnvironment
            ->setName((string) $name)
            ->setType((string) $type);

        if ($parameters) {
            $projectEnvironment->setParameters($parameters);
        }

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
