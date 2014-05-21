<?php

namespace Birgit\Bundle\CoreBundle\Entity\Project;

use Birgit\Bundle\CoreBundle\Entity\EntityRepository;
use Birgit\Model\Project\ProjectRepositoryInterface;
use Birgit\Bundle\CoreBundle\Entity\Project\Project;

/**
 * Project Repository
 */
class ProjectRepository extends EntityRepository implements ProjectRepositoryInterface
{
    public function create()
    {
        $project = new Project();
        
        return $project;
    }
}
