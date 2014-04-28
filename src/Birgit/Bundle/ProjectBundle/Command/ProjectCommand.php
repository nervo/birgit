<?php

namespace Birgit\Bundle\ProjectBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Birgit\Component\Build\BuildManager;
use Birgit\Component\Host\HostManager;
use Birgit\Component\Repository\RepositoryManager;
use Birgit\Component\Task\TaskManager;
use Birgit\Component\Project\ProjectManager;

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

        // Get host manager
        $hostManager = new HostManager($logger);

        // Get repository manager
        $repositoryManager = new RepositoryManager($logger);

        // Get task manager
        $taskManager = new TaskManager($logger);

        // Get build manager
        $buildManager = new BuildManager($repositoryManager, $taskManager, $logger);

        // Get project manager
        $projectManager = new ProjectManager($logger);

        // Get doctrine
        $doctrine = $this->getContainer()
            ->get('doctrine');

        // Get repositories
        $repositories = $doctrine
            ->getRepository('Birgit:Repository')
            ->findAll();

        foreach ($repositories as $repository) {

            $output->writeln(sprintf('Repository <comment>%s</comment>', $repository->getPath()));

            // Get scanned repository references
            $scannedRepositoryReferences = $repositoryManager->getRepositoryReferences($repository);

            foreach ($repository->getProjects() as $project) {

                $output->writeln(sprintf('Project <comment>%s</comment>', $project->getName()));

                // Don't handle inactive projects
                if (!$project->isActive()) {

                    $output->writeln(sprintf('Project is not active', $project->getName()));

                    continue;
                }

                foreach ($project->getEnvironments() as $projectEnvironment) {

                    $output->writeln(sprintf('Environment <comment>%s</comment>', $projectEnvironment->getName()));

                    // Don't handle inactive project environments
                    if (!$projectEnvironment->isActive()) {
                        continue;
                    }

                    foreach ($scannedRepositoryReferences as $scannedRepositoryReferenceName => $scannedRepositoryReferenceHash) {
                        // Does project environment feels concerned by a scanned repository reference ?
                        if ($projectManager->projectEnviromnentMatchRepositoryReferenceName($projectEnvironment, $scannedRepositoryReferenceName)) {

                            // Search repository reference
                            $repositoryReferenceFound = false;

                            foreach ($repository->getReferences() as $repositoryReference) {
                                if ($repositoryReference->getName() == $scannedRepositoryReferenceName) {
                                    $repositoryReferenceFound = true;
                                    break;
                                }
                            }
                            
                            // Create build
                            if (!$repositoryReferenceFound) {
                                $output->writeln(' -> Create repository reference');

                                $repositoryReference = (new Repository\Reference())
                                    ->setName($scannedRepositoryReferenceName);

                                $repository->addReference($repositoryReference);
                            }
                        }
                    }
                }
            }
        }

        die;

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

            // Get repository references
            $repositoryReferences = $repositoryManager->getRepositoryReferences($repository);

            foreach ($project->getEnvironments() as $projectEnvironment) {
                // Don't handle inactive project environments
                if (!$projectEnvironment->isActive()) {
                    continue;
                }

                $output->writeln(sprintf('For <comment>%s</comment> project environment', $projectEnvironment->getName()));

                foreach ($repositoryReferences as $repositoryReferenceName => $repositoryReferenceHash) {

                    $output->writeln(sprintf(' - Branch <comment>%s</comment>@<comment>%s</comment>', $repositoryReferenceName, $repositoryReferenceHash));

                    // Search project environment repository reference
                    $projectEnvironmentRepositoryReferenceFound = false;
                    foreach ($projectEnvironment->getRepositoryReferences() as $projectEnvironmentRepositoryReference) {
                        if ($projectEnvironmentRepositoryReference->getName() == $repositoryReferenceName) {
                            $projectEnvironmentRepositoryReferenceFound = true;
                            break;
                        }
                    }

                    // Create new project environment repository reference
                    if (!$projectEnvironmentRepositoryReferenceFound) {
                        $output->writeln(' -> Create project environment repository reference');

                        $projectEnvironmentRepositoryReference = (new Project\Environment\RepositoryReference())
                            ->setName($repositoryReferenceName)
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
                        if ($build->getRevision() == $repositoryReferenceHash) {
                            $buildFound = true;
                            break;
                        }
                    }

                    // Create build
                    if (!$buildFound) {
                        $output->writeln(' -> Create build');

                        $build = $buildManager->createBuild($projectEnvironmentRepositoryReference, $repositoryReferenceHash);

                        $doctrine->getManager()
                            ->persist($build);

                        $output->writeln(' -> Build');

                        // Build
                        $buildManager->build($build);
                    }
                }
            }
        }

        $doctrine->getManager()
            ->flush();
    }
}
