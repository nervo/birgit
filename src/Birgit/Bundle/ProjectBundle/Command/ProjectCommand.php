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
use Birgit\Entity\Host;
use Birgit\Entity\Build;

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
        // Get doctrine
        $doctrine = $this->getContainer()
            ->get('doctrine');

        // Get root dir
        $rootDir = realpath(
            $this->getContainer()
                ->get('kernel')
                ->getRootDir() .
            '/..'
        );

        // Get logger
        $logger = $this->getContainer()->get('logger');

        // Get host manager
        $hostManager = new HostManager(
            $doctrine->getManager(),
            $rootDir,
            $logger
        );

        // Get repository manager
        $repositoryManager = new RepositoryManager($logger);

        // Get task manager
        $taskManager = new TaskManager(
            $rootDir,
            $logger
        );

        // Get build manager
        $buildManager = new BuildManager(
            $doctrine->getManager(),
            $repositoryManager,
            $taskManager,
            $logger
        );

        // Get project manager
        $projectManager = new ProjectManager($logger);

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

                            // Find or create repository reference
                            $repositoryReferenceFound = false;

                            foreach ($repository->getReferences() as $repositoryReference) {
                                if ($repositoryReference->getName() === $scannedRepositoryReferenceName) {
                                    $repositoryReferenceFound = true;
                                    break;
                                }
                            }

                            if (!$repositoryReferenceFound) {
                                $output->writeln(' -> Create repository reference');

                                $repositoryReference = (new Repository\Reference())
                                    ->setName($scannedRepositoryReferenceName);

                                $repository->addReference($repositoryReference);

                                $doctrine->getManager()
                                    ->persist($repositoryReference);
                                $doctrine->getManager()
                                    ->flush();
                            }

                            // Find or create host
                            $hostFound = false;

                            foreach ($projectEnvironment->getHosts() as $host) {
                                if ($host->getRepositoryReference() === $repositoryReference) {
                                    $hostFound = true;
                                    break;
                                }
                            }

                            if (!$hostFound) {
                                $output->writeln(' -> Create host');

                                $host = $hostManager->createHost(
                                    $projectEnvironment,
                                    $repositoryReference
                                );
                            }

                            // Find or create repository reference revision
                            $repositoryReferenceRevisionFound = false;

                            foreach ($repositoryReference->getRevisions() as $repositoryReferenceRevision) {
                                if ($repositoryReferenceRevision->getHash() === $scannedRepositoryReferenceHash) {
                                    $repositoryReferenceRevisionFound = true;
                                    break;
                                }
                            }
                            
                            if (!$repositoryReferenceRevisionFound) {
                                $output->writeln(' -> Create repository reference revision');

                                $repositoryReferenceRevision = (new Repository\Reference\Revision())
                                    ->setHash($scannedRepositoryReferenceHash);

                                $repositoryReference->addRevision($repositoryReferenceRevision);

                                $doctrine->getManager()
                                    ->persist($repositoryReferenceRevision);
                                $doctrine->getManager()
                                    ->flush();
                            }

                            // Find or create build
                            $buildFound = false;

                            foreach ($host->getBuilds() as $build) {
                                if ($build->getRepositoryReferenceRevision() === $repositoryReferenceRevision) {
                                    $buildFound = true;
                                    break;
                                }
                            }
                            
                            if (!$buildFound) {
                                $output->writeln(' -> Create build');

                                $build = $buildManager->createBuild(
                                    $host,
                                    $repositoryReferenceRevision
                                );
                            }

                            // Build
                            $output->writeln(' -> Build');

                            // Build
                            $buildManager->build($build);
                        }
                    }
                }
            }
        }
    }
}
