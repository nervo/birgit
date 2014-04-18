<?php

namespace Birgit\Bundle\RepositoryBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Webcreate\Vcs\Git;

use Birgit\Entity\Repository;
use Birgit\Entity\Project;

class RepositoryCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('birgit:repository')
            ->setDescription('Birgit repository')
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
        $doctrine = $this->getContainer()
            ->get('doctrine');

        $repositoryRepository = $doctrine
            ->getRepository('Birgit:Repository');

        $repositories = $repositoryRepository->findAll();

        foreach ($repositories as $repository) {
            $output->writeln(
                sprintf(
                    'Handle <comment>%s</comment> repository',
                    $repository->getUrl()
                )
            );

            $git = new Git($repository->getUrl());

            foreach ($git->branches() as $gitBranch) {
                
                $output->writeln(
                    sprintf(
                        ' - Branch <comment>%s</comment> @ <comment>%s</comment>',
                        $gitBranch->getName(),
                        $gitBranch->getRevision()
                    )
                );

                foreach ($repository->getProjects() as $project) {
                    
                    // Search project branch
                    $projectBranchFound = false;
                    foreach ($project->getBranches() as $projectBranch) {
                        if ($projectBranch->getName() == $gitBranch->getName()) {
                            $projectBranchFound = true;
                            break;
                        }
                    }                    

                    if (!$projectBranchFound) {
                        $output->writeln(' -> Create project branch');

                        $projectBranch = new Project\Branch();
                        $projectBranch->setName($gitBranch->getName());

                        $project->addBranch($projectBranch);

                        $host = $project->getHostProvider()
                            ->createHost($projectBranch);
                        
                        $doctrine->getManager()
                            ->persist($host);
                    }
                
                    if ($projectBranch->getRevision() != $gitBranch->getRevision()) {
                        $output->writeln(' -> Update project branch revision');
                        $projectBranch->setRevision($gitBranch->getRevision());
                    }
                }
            }

            $doctrine->getManager()
                ->persist($repository);
        }

        $doctrine->getManager()
            ->flush();
    }
}
