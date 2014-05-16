<?php

namespace Birgit\Domain\Project;

use Doctrine\Common\Persistence\ManagerRegistry;

use Birgit\Domain\Project\Handler\ProjectHandlerInterface;
use Birgit\Model\Project\Project;
use Birgit\Model\Project\Reference\ProjectReference;
use Birgit\Domain\Project\Environment\Handler\ProjectEnvironmentHandlerInterface;
use Birgit\Model\Project\Environment\ProjectEnvironment;
use Birgit\Component\Exception\Exception;
use Birgit\Component\Parameters\Parameters;

/**
 * Project Manager
 */
class ProjectManager
{
    protected $doctrineManagerRegistry;

    /**
     * Project handlers
     *
     * @var array
     */
    protected $projectHandlers = array();
    
    /**
     * Project environment handlers
     *
     * @var array
     */
    protected $projectEnvironmentHandlers = array();

    public function __construct(ManagerRegistry $doctrineManagerRegistry)
    {
        $this->doctrineManagerRegistry = $doctrineManagerRegistry;
    }
    
    public function addProjectHandler(ProjectHandlerInterface $handler)
    {
        $this->projectHandlers[] = $handler;
        
        return $this;
    }
    
    public function getProjectHandler(Project $project)
    {
        $type = $project->getType();

        foreach ($this->projectHandlers as $handler) {
            if ($handler->getType() === $type) {
                return $handler;
            }
        }

        throw new Exception(sprintf('Project handler type "%s" not found', $type));
    }

    public function findProjects()
    {
        return $this->doctrineManagerRegistry
            ->getRepository('Birgit:Project\Project')
            ->findAll();
    }

    public function findProject($name)
    {
        return $this->doctrineManagerRegistry
            ->getRepository('Birgit:Project\Project')
            ->findOneByName($name);
    }
    
    public function createProject($name, $type, Parameters $parameters = null)
    {
        $project = $this->doctrineManagerRegistry
            ->getRepository('Birgit:Project\Project')
            ->create()
                ->setName((string) $name)
                ->setType((string) $type);
        
        if ($parameters) {
            $project->setParameters($parameters);
        }
        
        return $project;        
    }
    
    public function saveProject(Project $project)
    {
        $doctrineManager = $this->doctrineManagerRegistry
            ->getManager();
        
        $doctrineManager->persist($project);
        $doctrineManager->flush();
    }

    public function createProjectReference(Project $project, $name)
    {
        $projectReference = $this->doctrineManagerRegistry
            ->getRepository('Birgit:Project\Reference\ProjectReference')
            ->create()
                ->setName((string) $name);
        
        $project->addReference($projectReference);
        
        return $projectReference;        
    }
    
    public function saveProjectReference(ProjectReference $projectReference)
    {
        $doctrineManager = $this->doctrineManagerRegistry
            ->getManager();
        
        $doctrineManager->persist($projectReference);
        $doctrineManager->flush();
    }
    
    public function addProjectEnvironmentHandler(ProjectEnvironmentHandlerInterface $handler)
    {
        $this->projectEnvironmentHandlers[] = $handler;
        
        return $this;
    }
    
    public function getProjectEnvironmentHandler(ProjectEnvironment $projectEnvironment)
    {
        $type = $projectEnvironment->getType();

        foreach ($this->projectEnvironmentHandlers as $handler) {
            if ($handler->getType() === $type) {
                return $handler;
            }
        }

        throw new Exception(sprintf('Project environment handler type "%s" not found', $type));
    }
    
    public function createProjectEnvironment(Project $project, $name, $type, Parameters $parameters = null)
    {
        $projectEnvironment = $this->doctrineManagerRegistry
            ->getRepository('Birgit:Project\Environment\ProjectEnvironment')
            ->create()
                ->setName((string) $name)
                ->setType((string) $type);
        
        if ($parameters) {
            $projectEnvironment->setParameters($parameters);
        }
        
        $project->addEnvironment($projectEnvironment);
        
        return $projectEnvironment;        
    }

    public function saveProjectEnvironment(ProjectEnvironment $projectEnvironment)
    {
        $doctrineManager = $this->doctrineManagerRegistry
            ->getManager();
        
        $doctrineManager->persist($projectEnvironment);
        $doctrineManager->flush();
    }
}
