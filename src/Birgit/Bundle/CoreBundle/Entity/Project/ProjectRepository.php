<?php

namespace Birgit\Bundle\CoreBundle\Entity\Project;

use Birgit\Bundle\CoreBundle\Entity\EntityRepository;
use Birgit\Model\Project\ProjectRepositoryInterface;
use Birgit\Component\Parameters\Parameters;
use Birgit\Bundle\CoreBundle\Entity\Project\Project;

/**
 * Project Repository
 */
class ProjectRepository extends EntityRepository implements ProjectRepositoryInterface
{
    public function create($name, $type, Parameters $parameters = null)
    {
        $project = $this->createEntity();
        
        $project
            ->setName((string) $name)
            ->setType((string) $type);

        if ($parameters) {
            $project->setParameters($parameters);
        }
        
        return $project;
    }
    
    public function save(Project $project)
    {
        $this->saveEntity($project);
    }
}
