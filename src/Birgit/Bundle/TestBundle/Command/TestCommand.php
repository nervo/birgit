<?php

namespace Birgit\Bundle\TestBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Birgit\Domain\Workflow\WorkflowEvents;
use Birgit\Domain\Project\Event\ProjectEvent;

/**
 * Test command
 */
class TestCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('birgit:test')
            ->setDescription('Birgit test')
            ->setHelp(<<<EOF
The <info>%command.name%</info> command does things:

<info>php %command.full_name%</info>

EOF
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Get model manager
        $modelManager = $this->getContainer()
            ->get('birgit.model_manager');

        // Get project
        $project = $modelManager
            ->getProjectRepository()
            ->get('test');

        // Dispatch event
        $this->getContainer()
            ->get('event_dispatcher')
            ->dispatch(
                WorkflowEvents::PROJECT,
                new ProjectEvent($project)
            );
    }
}
