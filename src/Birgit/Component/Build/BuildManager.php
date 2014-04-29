<?php

namespace Birgit\Component\Build;

use Psr\Log\LoggerInterface;

use Doctrine\Common\Persistence\ObjectManager;

use Birgit\Component\Repository\RepositoryManager;
use Birgit\Component\Task\TaskManager;

use Birgit\Task;
use Birgit\Entity\Build;
use Birgit\Entity\Project;
use Birgit\Entity\Host;
use Birgit\Entity\Repository;

/**
 * Build manager
 */
class BuildManager
{
    /**
     * Object manager
     *
     * @var ObjectManager
     */
    protected $objectManager;

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
     * @param ObjectManager     $objectManager
     * @param RepositoryManager $repositoryManager
     * @param TaskManager       $taskManager
     * @param LoggerInterface   $logger
     */
	public function __construct(ObjectManager $objectManager, RepositoryManager $repositoryManager, TaskManager $taskManager, LoggerInterface $logger)
	{
        // Object manager
        $this->objectManager = $objectManager;

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
     * @param Host                          $host
     * @param Repository\Reference\Revision $repositoryReferenceRevision
     *
     * @return Build
     */
    public function createBuild(Host $host, Repository\Reference\Revision $repositoryReferenceRevision)
    {
        $build = new Build();

        $host->addBuild($build);
        $repositoryReferenceRevision->addBuild($build);
        
        $this->objectManager->persist($build);
        $this->objectManager->flush();

        return $build;
    }

    /**
     * Build
     *
     * @param Build $build
     */
	public function build(Build $build)
	{
        // Git checkout task
        $task = new Task\GitCheckoutTask();
        $task->execute($this->taskManager, $build);

        // PHPUnit task
        $task = new Task\PHPUnitTask();
        $task->execute($this->taskManager, $build);
	}
}
