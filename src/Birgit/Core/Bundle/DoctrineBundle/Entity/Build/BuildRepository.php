<?php

namespace Birgit\Core\Bundle\DoctrineBundle\Entity\Build;

use Birgit\Core\Bundle\DoctrineBundle\Entity\EntityRepository;
use Birgit\Core\Model\Build\BuildRepositoryInterface;
use Birgit\Core\Bundle\DoctrineBundle\Entity\Host\Host;
use Birgit\Core\Bundle\DoctrineBundle\Entity\Project\Reference\Revision\ProjectReferenceRevision;
use Birgit\Core\Exception\Model\ModelNotFoundException;

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

    public function get($id)
    {
        $build = $this->findOneById($id);

        if (!$build) {
            throw new ModelNotFoundException();
        }

        return $build;
    }
}
