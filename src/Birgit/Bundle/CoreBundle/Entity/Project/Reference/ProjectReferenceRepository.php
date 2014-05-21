<?php

namespace Birgit\Bundle\CoreBundle\Entity\Project\Reference;

use Birgit\Bundle\CoreBundle\Entity\EntityRepository;
use Birgit\Model\Project\Reference\ProjectReferenceRepositoryInterface;
use Birgit\Bundle\CoreBundle\Entity\Project\Project;
use Birgit\Bundle\CoreBundle\Entity\Project\Reference\ProjectReference;
use Birgit\Component\Exception\Model\ModelNotFoundException;

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
