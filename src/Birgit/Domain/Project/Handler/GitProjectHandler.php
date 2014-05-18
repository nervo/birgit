<?php

namespace Birgit\Domain\Project\Handler;

use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\ProcessBuilder;

use Birgit\Model\Project\Project;
use Birgit\Component\Context\ContextInterface;

/**
 * Git Project handler
 */
class GitProjectHandler extends ProjectHandler
{
    public function getType()
    {
        return 'git';
    }

    public function isUp(Project $project, ContextInterface $context)
    {
        $context->getLogger()->notice('Git Project: isUp');

        return true;
    }

    public function getReferences(Project $project, ContextInterface $context)
    {
        // Get path
        $path = $project->getParameters()
            ->get('path');

        // Log
        $context->getLogger()->notice(sprintf('Git Project: Get "%s" references', $path));

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
}
