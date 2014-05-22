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
            ->getRepository('BirgitDoctrineBundle:Build\Build');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getHostRepository()
    {
        return $this->managerRegistry
            ->getRepository('BirgitDoctrineBundle:Host\Host');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getProjectRepository()
    {
        return $this->managerRegistry
            ->getRepository('BirgitDoctrineBundle:Project\Project');
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectEnvironmentRepository()
    {
        return $this->managerRegistry
            ->getRepository('BirgitDoctrineBundle:Project\Environment\ProjectEnvironment');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getProjectReferenceRepository()
    {
        return $this->managerRegistry
            ->getRepository('BirgitDoctrineBundle:Project\Reference\ProjectReference');
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectReferenceRevisionRepository()
    {
        return $this->managerRegistry
            ->getRepository('BirgitDoctrineBundle:Project\Reference\Revision\ProjectReferenceRevision');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTaskRepository()
    {
        return $this->managerRegistry
            ->getRepository('BirgitDoctrineBundle:Task\Task');
    }
    
    /**
     * {@inheritdoc}
     */
    public function getTaskQueueRepository()
    {
        return $this->managerRegistry
            ->getRepository('BirgitDoctrineBundle:Task\Queue\TaskQueue');
    }
}
