<?php

namespace Birgit\Component\Build;

use Psr\Log\LoggerInterface;

use Birgit\Component\Repository\RepositoryManager;
use Birgit\Component\Task\TaskManager;

use Birgit\Task;
use Birgit\Entity\Build;
use Birgit\Entity\Project;
use Birgit\Entity\Host;

/**
 * Build manager
 */
class BuildManager
{
    /**
     * Repository manager
     *
     * @var repositoryManager
     */
    protected $repositoryManager;

    /**
     * Task manager
     *
     * @var taskManager
     */
    protected $taskManager;

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
     * @param TaskManager       $taskManager
     * @param LoggerInterface   $logger
     */
	public function __construct(RepositoryManager $repositoryManager, TaskManager $taskManager, LoggerInterface $logger)
	{
        // Repository manager
        $this->repositoryManager = $repositoryManager;

        // Task manager
        $this->taskManager = $taskManager;

    	// Logger
    	$this->logger = $logger;
	}

    /**
     * Create build
     *
     * @param Project\Environment\RepositoryReference $projectEnvironmentRepositoryReference
     * @param string                                  $revision
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
        $taskParameters = new Task\GitCheckoutTaskParameters();
        
        $task = new Task\GitCheckoutTask($taskParameters);
        var_dump('yeah');
        die;


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
