<?php

namespace Birgit\Component\Repository;

use Symfony\Component\Process\ExecutableFinder;
use Symfony\Component\Process\ProcessBuilder;

use Birgit\Component\Exception\Exception;

/**
 * Git Repository
 */
class GitRepository extends Repository
{
    public function getParametersClass()
    {
        return get_class($this) . 'Parameters';
    }

    public function getReferences(RepositoryContext $context, RepositoryParameters $parameters)
    {
    	if (!$parameters instanceof GitRepositoryParameters) {
    		throw new Exception();
    	}

    	// Log
    	$context->getLogger()->notice(sprintf('Git Repository: Get "%s" references', $parameters->getPath()));

        // Find git executable
        $executableFinder = new ExecutableFinder();
        $gitExecutable = $executableFinder->find('git', '/usr/bin/git');

        $builder = new ProcessBuilder();
        $process = $builder
            ->setPrefix($gitExecutable)
            ->setArguments(array('ls-remote', $parameters->getPath()))
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
