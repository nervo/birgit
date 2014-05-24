<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Project;

use Birgit\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Model\Project\ProjectRepositoryInterface;
use Birgit\Domain\Exception\Model\ModelNotFoundException;
use Birgit\Bundle\DoctrineBundle\Entity\Project\Project;
use Birgit\Domain\Handler\HandlerDefinition;

/**
 * Project Repository
 */
class ProjectRepository extends EntityRepository implements ProjectRepositoryInterface
{
    public function create($name, HandlerDefinition $handlerDefinition)
    {
        $project = $this->createEntity();
        
        $project
            ->setName((string) $name)
            ->setHandlerDefinition($handlerDefinition);
        
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
