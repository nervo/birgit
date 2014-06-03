<?php

namespace Birgit\Bundle\DoctrineBundle\Entity;

use Birgit\Model\ModelManagerInterface;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * Entity Manager
 */
class EntityManager implements ModelManagerInterface
{
    /**
     * Manager registry
     *
     * @var ManagerRegistry
     */
    protected $managerRegistry;

    /**
     * Constructor
     *
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        // Manager registry
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function getBuildRepository()
    {
        return $this->managerRegistry
            ->getRepository('BirgitDoctrineBundle:Build\Build', 'birgit');
    }

    /**
     * {@inheritdoc}
     */
    public function getHostRepository()
    {
        return $this->managerRegistry
            ->getRepository('BirgitDoctrineBundle:Host\Host', 'birgit');
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectRepository()
    {
        return $this->managerRegistry
            ->getRepository('BirgitDoctrineBundle:Project\Project', 'birgit');
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectEnvironmentRepository()
    {
        return $this->managerRegistry
            ->getRepository('BirgitDoctrineBundle:Project\Environment\ProjectEnvironment', 'birgit');
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectReferenceRepository()
    {
        return $this->managerRegistry
            ->getRepository('BirgitDoctrineBundle:Project\Reference\ProjectReference', 'birgit');
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectReferenceRevisionRepository()
    {
        return $this->managerRegistry
            ->getRepository('BirgitDoctrineBundle:Project\Reference\Revision\ProjectReferenceRevision', 'birgit');
    }
}
