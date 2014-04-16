<?php

namespace Birgit\Bundle\RepositoryBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use GitElephant\Repository as GitRepository;

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
    	// Logger
    	$logger = $this->getContainer()->get('logger');

    	//$logger->emergency('emergency');
    	//$logger->alert('alert');
    	//$logger->critical('critical');
    	//$logger->error('error');
    	//$logger->warning('warning');
    	//$logger->notice('notice');
    	//$logger->info('info');
    	//$logger->debug('debug');

        //$output->writeln(sprintf('Hello <comment>%s</comment>!', $input->getArgument('who')));

        $repositoryRepository = $this->getContainer()
        	->get('doctrine')
        	->getRepository('BirgitRepositoryBundle:Repository');

       	$repositories = $repositoryRepository->findAll();

       	foreach ($repositories as $repository) {
       		var_dump($repository->getUrl());
       		
       		$gitRepository = new GitRepository($repository->getUrl());


			$repo = new Repository('/path/to/git/repository');
			$connection = ssh_connect('host', 'port');
			// authorize the connection with the method you want
			ssh2_auth_password($connection, 'user', 'password');
			$caller = new CallerSSH2($connection, '/path/to/git/binary/on/server');
			$repo = Repository::open('/path/to/git/repository');
			$repo->setCaller($caller);



       	}
    }
}
