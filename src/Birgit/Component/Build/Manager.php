<?php

namespace Birgit\Component\Build;

use Psr\Log\LoggerInterface;

use Birgit\Component\Repository\Manager as RepositoryManager;

use Birgit\Entity\Build;
use Birgit\Entity\Project;
use Birgit\Entity\Host;

/**
 * Build manager
 */
class Manager
{
    /**
     * Repository manager
     *
     * @var repositoryManager
     */
    protected $repositoryManager;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor
     *
     * @param RepositoryManager $repositoryManager
     * @param LoggerInterface   $logger
     */
	public function __construct(repositoryManager $repositoryManager, LoggerInterface $logger)
	{
        // Repository manager
        $this->repositoryManager = $repositoryManager;

    	// Logger
    	$this->logger = $logger;
	}

    /**
     * Create build
     *
     * @param PProject\Environment\RepositoryReference $projectEnvironmentRepositoryReference
     * @param string                                   $revision
     *
     * @return Build
     */
    public function createBuild(Project\Environment\RepositoryReference $projectEnvironmentRepositoryReference, $revision)
    {
        $build = (new Build())
            ->setProjectEnvironmentRepositoryReference($projectEnvironmentRepositoryReference)
            ->setRevision($revision);

        return $build;
    }


    /**
     * Build
     *
     * @param Build $build
     */
	public function build(Build $build)
	{
        // Get project environment repository reference
        $projectEnvironmentRepositoryReference = $build->getProjectEnvironmentRepositoryReference();
        
        // Get project environment
        $projectEnvironment = $projectEnvironmentRepositoryReference->getProjectEnvironment();

        // Get project
        $project = $projectEnvironment->getProject();

        // Create repository client
        $repositoryClient = $this->repositoryManager->createClient($project->getRepository());

        $workspace = 'data/workspace' .
            '/' .
            $project->getName() .
            '/' .
            $projectEnvironment->getName() .
            '/' .
            $projectEnvironmentRepositoryReference->getName();

        $repositoryClient->checkout($workspace);

        return $build;
	}
}
