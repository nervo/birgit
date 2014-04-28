<?php

namespace Birgit\Component\Project;

use Psr\Log\LoggerInterface;

use Birgit\Entity\Project;

/**
 * Project manager
 */
class ProjectManager
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
     * @param LoggerInterface   $logger
     */
	public function __construct(LoggerInterface $logger)
	{
    	// Logger
    	$this->logger = $logger;
	}

    /**
     * Match repositoryReference
     *
     * @param Project\Environment $projectEnvironment
     * @param string              $repositoryReferenceName
     *
     * @return Build
     */
    public function projectEnviromnentMatchRepositoryReferenceName(Project\Environment $projectEnvironment, $repositoryReferenceName)
    {
    	return fnmatch(
    		$projectEnvironment->getRepositoryReferencePattern(),
    		$repositoryReferenceName
    	);
    }
}
