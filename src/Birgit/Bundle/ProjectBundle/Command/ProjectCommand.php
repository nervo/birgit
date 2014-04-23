<?php

namespace Birgit\Bundle\ProjectBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Birgit\Component\Git\Client as GitClient;

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

        $doctrine = $this->getContainer()
            ->get('doctrine');

        $projectRepository = $doctrine
            ->getRepository('Birgit:Project');

        $projects = $projectRepository->findAll();

        foreach ($projects as $project) {
            
            $repository = $project->getrepository();

            $output->writeln(
                sprintf(
                    'Handle <comment>%s</comment> repository',
                    $repository->getPath()
                )
            );

            $gitClient = new GitClient($logger);
            $gitClient->setRepository($repository->getPath());

            foreach ($gitClient->getBranches() as $gitBranch) {
                
                $output->writeln(
                    sprintf(
                        ' - Branch <comment>%s</comment> @ <comment>%s</comment>',
                        $gitBranch->getName(),
                        $gitBranch->getHash()
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


                        $gitClient->checkout(
                            'data/projects' .
                            '/' .
                            $project->getName() .
                            '/' .
                            $projectBranch->getName()
                        );
                    }
                
                    if ($projectBranch->getRevision() != $gitBranch->getHash()) {
                        $output->writeln(' -> Update project branch revision');
                        $projectBranch->setRevision($gitBranch->getHash());
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
