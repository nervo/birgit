<?php

namespace Birgit\Bundle\CoreBundle\Entity\Project\Environment;

use Birgit\Bundle\CoreBundle\Entity\EntityRepository;
use Birgit\Model\Project\Environment\ProjectEnvironmentRepositoryInterface;
use Birgit\Bundle\CoreBundle\Entity\Project\Project;
use Birgit\Bundle\CoreBundle\Entity\Project\Environment\ProjectEnvironment;
use Birgit\Component\Parameters\Parameters;

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
    
    public function findOneByProjectAndName(Project $project, $name)
    {
        return $this->findOneBy(array(
            'project' => $project,
            'name'    => $name
        ));
    }
}
