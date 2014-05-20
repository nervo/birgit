<?php

namespace Birgit\Bundle\CoreBundle\Entity\Project\Reference;

use Birgit\Bundle\CoreBundle\Entity\EntityRepository;
use Birgit\Bundle\CoreBundle\Entity\Project\Project;

/**
 * Project reference Repository
 */
class ProjectReferenceRepository extends EntityRepository
{
    public function findOneByProjectAndName(Project $project, $name)
    {
        return $this->findOneBy(array(
            'project' => $project,
            'name'    => $name
        ));
    }
}
