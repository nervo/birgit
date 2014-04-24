<?php

namespace Birgit\Component\Build;

use Psr\Log\LoggerInterface;

use Birgit\Component\Git\Client as GitClient;

use Birgit\Entity\Build;
use Birgit\Entity\Project;
use Birgit\Entity\Host;

/**
 * Build manager
 */
class Manager
{
    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
	public function __construct(LoggerInterface $logger)
	{
    	// Logger
    	$this->logger = $logger;
	}

    /**
     * Build
     *
     * @param Project\Reference $projectReference
     * @param string            $hash
     *
     * @return Build
     */
	public function build(Project\Reference $projectReference, $hash, Host $host)
	{
		// Get project
		$project = $projectReference->getProject();

		// Create build
        $build = new Build();
        $build->setHash($hash);
        $projectReference->addBuild($build);

        // Create git client
        $gitClient = new GitClient($this->logger);
        $gitClient->setRepository($project->getRepository()->getPath());

        $gitClient->checkout(
            'data/projects' .
            '/' .
            $project->getName() .
            '/' .
            $projectReference->getName()
        );

        return $build;
	}
}
