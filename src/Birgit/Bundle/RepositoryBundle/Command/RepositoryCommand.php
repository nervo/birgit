<?php

namespace Birgit\Bundle\RepositoryBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Webcreate\Vcs\Git;

use Birgit\Entity\Repository;

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

	       		// Search branch
	       		$repositoryBranchFound = false;
	       		foreach ($repository->getBranches() as $repositoryBranch) {
	       			if ($repositoryBranch->getName() == $gitBranch->getName()) {
	       				$repositoryBranchFound = true;
	       				break;
	       			}
	       		}

	       		if (!$repositoryBranchFound) {
		       		$output->writeln(' -> Create branch');

		       		$repositoryBranch = new Repository\Branch();
		       		$repositoryBranch->setName($gitBranch->getName());

		       		$repository->addBranch($repositoryBranch);
	       		}

	       		// Search branch revision
	       		$repositoryBranchRevisionFound = false;
	       		foreach ($repositoryBranch->getRevisions() as $repositoryBranchRevision) {
	       			if ($repositoryBranchRevision->getName() == $gitBranch->getRevision()) {
	       				$repositoryBranchRevisionFound = true;
	       				break;
	       			}
	       		}

	       		if (!$repositoryBranchRevisionFound) {
		       		$output->writeln(' -> Create revision');

		       		$repositoryBranchRevision = new Repository\Branch\Revision();
		       		$repositoryBranchRevision->setName($gitBranch->getRevision());

		       		$repositoryBranch->addRevision($repositoryBranchRevision);
	       		}
            }

            $doctrine->getManager()
            	->persist($repository);
       	}

       	$doctrine->getManager()
       		->flush();
    }
}
