<?php

namespace Birgit\Bundle\CoreBundle\Entity\Project\Environment;

use Birgit\Bundle\CoreBundle\Entity\EntityRepository;
use Birgit\Bundle\CoreBundle\Entity\Project\Project;
use Birgit\Bundle\CoreBundle\Entity\Project\Environment\ProjectEnvironment;

/**
 * Project environment Repository
 */
class ProjectEnvironmentRepository extends EntityRepository
{
    public function create()
    {
        $projectEnvironment = new ProjectEnvironment();
        
        return $projectEnvironment;
    }

    public function findOneByProjectAndName(Project $project, $name)
    {
        return $this->findOneBy(array(
            'project' => $project,
            'name'    => $name
        ));
    }
}
