<?php

namespace Birgit\Bundle\CoreBundle\Entity\Project\Reference\Revision;

use Birgit\Bundle\CoreBundle\Entity\EntityRepository;
use Birgit\Bundle\CoreBundle\Entity\Project\Reference\ProjectReference;

/**
 * Project reference revision Repository
 */
class ProjectReferenceRevisionRepository extends EntityRepository
{
    public function findOneByProjectReferenceAndName(ProjectReference $projectReference, $name)
    {
        return $this->findOneBy(array(
            'reference' => $projectReference,
            'name'      => $name
        ));
    }
}
