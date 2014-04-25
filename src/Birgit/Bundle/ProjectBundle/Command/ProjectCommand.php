<?php

namespace Birgit\Bundle\ProjectBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Birgit\Component\Build\Manager as BuildManager;
use Birgit\Component\Host\Manager as HostManager;
use Birgit\Component\Repository\Manager as RepositoryManager;

use Birgit\Entity\Repository;
use Birgit\Entity\Project;

class ProjectCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('birgit:project')
            ->setDescription('Birgit project')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command greets does things:

<info>php %command.full_name%</info>

EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get logger
        $logger = $this->getContainer()->get('logger');

        // Get build manager
        $buildManager = new BuildManager($logger);

        // Get host manager
        $hostManager = new HostManager($logger);

        // Get repository manager
        $repositoryManager = new RepositoryManager($logger);

        // Get doctrine
        $doctrine = $this->getContainer()
            ->get('doctrine');

        // Get projects
        $projects = $doctrine
            ->getRepository('Birgit:Project')
            ->findAll();

        foreach ($projects as $project) {

            // Don't handle inactive projects
            if (!$project->isActive()) {
                continue;
            }

            $output->writeln(sprintf('Handle <comment>%s</comment> project', $project->getName()));

            // Get repository
            $repository = $project->getrepository();

            $output->writeln(sprintf('On <comment>%s</comment> repository', $repository->getPath()));

            // Create repository client
            $repositoryClient = $repositoryManager->createClient($repository);

            // Get git branches
            $gitBranches = $repositoryClient->getBranches();

            foreach ($project->getEnvironments() as $projectEnvironment) {
                // Don't handle inactive project environments
                if (!$projectEnvironment->isActive()) {
                    continue;
                }

                $output->writeln(sprintf('For <comment>%s</comment> project environment', $projectEnvironment->getName()));

                foreach ($gitBranches as $gitBranch) {

                    $output->writeln(sprintf(' - Branch <comment>%s</comment>@<comment>%s</comment>', $gitBranch->getName(), $gitBranch->getHash()));

                    // Search project environment repository reference
                    $projectEnvironmentRepositoryReferenceFound = false;
                    foreach ($projectEnvironment->getRepositoryReferences() as $projectEnvironmentRepositoryReference) {
                        if ($projectEnvironmentRepositoryReference->getName() == $gitBranch->getName()) {
                            $projectEnvironmentRepositoryReferenceFound = true;
                            break;
                        }
                    }

                    // Create new project environment repository reference
                    if (!$projectEnvironmentRepositoryReferenceFound) {
                        $output->writeln(' -> Create project environment repository reference');

                        $projectEnvironmentRepositoryReference = (new Project\Environment\RepositoryReference())
                            ->setName($gitBranch->getName())
                            ->setProjectEnvironment($projectEnvironment);

                        // Host
                        $host = $hostManager->createHost($projectEnvironment->getHostProvider());

                        $projectEnvironmentRepositoryReference
                            ->setHost($host);

                        $doctrine->getManager()
                            ->persist($projectEnvironmentRepositoryReference);
                    }

                    // Search build
                    $buildFound = false;
                    foreach ($projectEnvironmentRepositoryReference->getBuilds() as $build) {
                        if ($build->getHash() == $gitBranch->getHash()) {
                            $buildFound = true;
                            break;
                        }
                    }

                    // Create build
                    if (!$buildFound) {
                        $output->writeln(' -> Create build');


                        //$host = $project->getHostProvider()
                        //    ->createHost($projectReference);

                        //$buildManager->build($projectReference, $gitBranch->getHash(), $host);
                    }
                }
            }

            /*

            // Create git client
            $repOsitoryClient = new GitClient($logger);
            $repOsitoryClient->setRepository($repository->getPath());

            foreach ($repOsitoryClient->getBranches() as $gitBranch) {
                
                $output->writeln(sprintf(' - Branch <comment>%s</comment>@<comment>%s</comment>', $gitBranch->getName(), $gitBranch->getHash()));
                    
                // Search project reference
                $projectReferenceFound = false;
                foreach ($project->getReferences() as $projectReference) {
                    if ($projectReference->getName() == $gitBranch->getName()) {
                        $projectReferenceFound = true;
                        break;
                    }
                }

                if (!$projectReferenceFound) {
                    $output->writeln(' -> Create project reference');

                    $projectReference = new Project\Reference();
                    $projectReference->setName($gitBranch->getName());

                    $project->addReference($projectReference);
                }
            
                // Search build
                $buildFound = false;
                foreach ($projectReference->getBuilds() as $build) {
                    if ($build->getHash() == $gitBranch->getHash()) {
                        $buildFound = true;
                        break;
                    }
                }

                if (!$buildFound) {
                    $output->writeln(' -> Create build');


                    $host = $project->getHostProvider()
                        ->createHost($projectReference);

                    $buildManager->build($projectReference, $gitBranch->getHash(), $host);
                }
            }

            $doctrine->getManager()
                ->persist($repository);

            */
        }

        $doctrine->getManager()
            ->flush();
    }
}