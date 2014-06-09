<?php

namespace Birgit\Base\Git\Project\Type;

use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\ProcessBuilder;

use Birgit\Core\Project\Type\ProjectType;
use Birgit\Core\Model\Project\Project;
use Birgit\Core\Model\Project\Reference\ProjectReference;
use Birgit\Component\Task\Model\Task\Task;
use Birgit\Component\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Core\Exception\Exception;

/**
 * Git Project type
 */
class GitProjectType extends ProjectType
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'git';
    }

    /**
     * {@inheritdoc}
     */
    public function isUp(Project $project, TaskQueueContextInterface $context)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function getReferences(Project $project, TaskQueueContextInterface $context)
    {
        // Get path
        $path = $project->getTypeDefinition()->getParameter('path');

        // Find git executable
        $executableFinder = new ExecutableFinder();
        $gitExecutable = $executableFinder->find('git', '/usr/bin/git');

        $builder = new ProcessBuilder();
        $process = $builder
            ->setPrefix($gitExecutable)
            ->setArguments(array('ls-remote', $path))
            ->getProcess();

        // Log
        $context->getLogger()->info($process->getCommandLine());

        $process->run();

        $lines = explode("\n", rtrim($process->getOutput()));

        // Log
        foreach ($lines as $line) {
            $context->getLogger()->debug($line);
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

    /**
     * {@inheritdoc}
     */
    public function getReferenceRevision(ProjectReference $projectReference, TaskQueueContextInterface $context)
    {
        $references = $this->getReferences($projectReference->getProject(), $context);

        foreach ($references as $referenceName => $referenceRevision) {
            if ($projectReference->getName() === $referenceName) {
                return $referenceRevision;
            }
        }

        throw new Exception(sprintf('No revision found for Project Reference "%s"', $projectReference->getName()));
    }

    /**
     * {@inheritdoc}
     */
    public function onProjectTask(Task $task, TaskQueueContextInterface $context)
    {
        // Get task manager
        $taskManager = $context->getTaskManager();

        // Get task queue
        $taskQueue = $context->getTaskQueue();

        $taskQueue
            ->addTask(
                $taskManager->createTask('project_status')
            )
            ->addTask(
                $taskManager->createTask('project_references')
            );
    }
}
