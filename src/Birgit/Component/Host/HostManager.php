<?php

namespace Birgit\Component\Host;

use Psr\Log\LoggerInterface;

use Doctrine\Common\Persistence\ObjectManager;

use Symfony\Component\Filesystem\Filesystem;

use Birgit\Component\Command\Command;

use Birgit\Entity\HostProvider;
use Birgit\Entity\Host;
use Birgit\Entity\Project;
use Birgit\Entity\Repository;

/**
 * Host manager
 */
class HostManager
{
    /**
     * Object manager
     *
     * @var ObjectManager
     */
    protected $objectManager;

    /**
     * Root dir
     *
     * @var string
     */
    protected $rootDir;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * Constructor
     *
     * @param ObjectManager   $objectManager
     * @param string          $rootDir
     * @param LoggerInterface $logger
     */
	public function __construct(ObjectManager $objectManager, $rootDir, LoggerInterface $logger)
	{
        // Object manager
        $this->objectManager = $objectManager;

        // Root dir
        $this->rootDir = $rootDir;

    	// Logger
    	$this->logger = $logger;
	}

    /**
     * Create host
     *
     * @param Project\Environment  $projectEnvironment
     * @param Repository\Reference $repositoryReference
     *
     * @return Host
     */
	public function createHost(Project\Environment $projectEnvironment, Repository\Reference $repositoryReference)
	{
        $host = new Host();

        $projectEnvironment->addHost($host);
        $repositoryReference->addHost($host);

        $this->objectManager->persist($host);
        $this->objectManager->flush();

        // Create workspace
        $fileSystem = new Filesystem();
        $fileSystem->mkdir(
            $this->rootDir . '/' . $host->getWorkspace()
        );

		return $host;
	}
}
