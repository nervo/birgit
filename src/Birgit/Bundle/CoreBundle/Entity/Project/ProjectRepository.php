<?php

namespace Birgit\Bundle\CoreBundle\Entity\Project;

use Birgit\Bundle\CoreBundle\Entity\EntityRepository;
use Birgit\Bundle\CoreBundle\Entity\Project\Project;

/**
 * Project Repository
 */
class ProjectRepository extends EntityRepository
{
    public function create()
    {
        $project = new Project();
        
        return $project;
    }
}
