<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Build;

use Birgit\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Model\Build\BuildRepositoryInterface;
use Birgit\Bundle\DoctrineBundle\Entity\Host\Host;
use Birgit\Bundle\DoctrineBundle\Entity\Project\Reference\Revision\ProjectReferenceRevision;

/**
 * Build Repository
 */
class BuildRepository extends EntityRepository implements BuildRepositoryInterface
{
    public function create(Host $host, ProjectReferenceRevision $projectReferenceRevision)
    {
        $build = $this->createEntity();

        $build
            ->setHost($host)
            ->setProjectReferenceRevision($projectReferenceRevision);

        return $build;
    }

    public function save(Build $build)
    {
        $this->saveEntity($build);
    }
}
