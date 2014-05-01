<?php

namespace Birgit\Component\Repository;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Birgit\Component\Task\TaskManager;

//use Psr\Log\LoggerInterface;

//use Symfony\Component\Process\ExecutableFinder;
//use Symfony\Component\Process\ProcessBuilder;

//use Birgit\Entity\Repository;

/**
 * Repository manager
 */
class RepositoryManager implements EventSubscriberInterface
{
    /**
     * Repository types
     *
     * @var array
     */
    protected $repositoryTypes = array();

    protected $taskManager;

    public function __construct(TaskManager $taskManager)
    {
        $this->taskManager = $taskManager;
    }

    public function addRepositoryType($type, RepositoryInterface $repository)
    {
        $this->repositoryTypes[(string) $type] = $repository;
    }

    public function getRepositoryType($type)
    {
        return $this->repositoryTypes[(string) $type];
    }

    public function onReferenceCreation(Reference\Event\RepositoryReferenceCreationEvent $event)
    {
        var_dump('yeah');

        // Create task context
        /*
        $taskContext = new TaskContext(
            $this->getContainer()->get('logger')
        );
        */

        // Get task
        $task = $this->taskManager->getTaskType('repository_reference_create');

        //var_dump($taskManager);
        var_dump($task);

        //$task->execute($taskContext);
        die;
    }

    public static function getSubscribedEvents()
    {
        return array(
            Reference\RepositoryReferenceEvents::CREATION => 'onReferenceCreation'
        );
    }
    /**
     * Logger
     *
     * @var LoggerInterface
     */
    //protected $logger;

    /**
     * Constructor
     *
     * @param LoggerInterface $logger
     */
    /*
    public function __construct(LoggerInterface $logger)
    {
        // Logger
        $this->logger = $logger;
    }
    */

    /**
     * Get repository references
     *
     * @param Repository $repository
     *
     * @return array
     */
    /*
    public function getRepositoryReferences(Repository $repository)
    {
        // Find git executable
        $executableFinder = new ExecutableFinder();
        $gitExecutable = $executableFinder->find('git', '/usr/bin/git');

        $builder = new ProcessBuilder();
        $process = $builder
            ->setPrefix($gitExecutable)
            ->setArguments(array('ls-remote', $repository->getPath()))
            ->getProcess();

        // Log command input
        $this->logger->notice($process->getCommandLine());

        $process->run();

        $lines = explode("\n", rtrim($process->getOutput()));

        // Log command output
        foreach ($lines as $line) {
            $this->logger->info($line);
        }

        $references = array();
        
        foreach ($lines as $line) {
            list($hash, $reference) = explode("\t", $line);
            if (strpos($reference, 'refs/') === 0) {
                $references[str_replace('refs/', '', $reference)] = $hash;
            }
        }

        return $references;
    }
    */
}
