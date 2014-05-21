<?php

namespace Birgit\Bundle\TestBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Birgit\Component\Parameters\Parameters;

class TestFixturesCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('birgit:test:fixtures')
            ->setDescription('Birgit test fixtures')
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
        $projectsDefinitions = array(
            'test'  => array(
                'active'       => true,
                'type'         => 'git',
                'parameters'   => array(
                    //'path' => 'git@github.com:nervo/birgit-test.git'
                    'path' => '~/workspace/birgit-test'
                ),
                'environments' => array(
                    'test'    => array(
                        'active'            => true,
                        'type'              => 'local',
                        'parameters'        => array(
                            'workspace' => 'workspace'
                        ),
                        'reference_pattern' => 'heads/*'
                    ),
                    'quality' => array(
                        'active'            => true,
                        'type'              => 'local',
                        'parameters'        => array(
                            'workspace' => 'workspace'
                        ),
                        'reference_pattern' => 'heads/*'
                    )
                )
            ),
            'adele' => array(
                'active'       => true,
                'type'         => 'git',
                'parameters'   => array(
                    //'path' => 'git@github.com:Elao/adele.git'
                    'path' => '~/workspace/elao/adele'
                ),
                'environments' => array(
                    'test'    => array(
                        'active'            => true,
                        'type'              => 'local',
                        'parameters'        => array(
                            'workspace' => 'workspace'
                        ),
                        'reference_pattern' => 'heads/*'
                    ),
                    'quality' => array(
                        'active'            => true,
                        'type'              => 'local',
                        'parameters'        => array(
                            'workspace' => 'workspace'
                        ),
                        'reference_pattern' => 'heads/*'
                    ),
                    'demo'    => array(
                        'active'            => true,
                        'type'              => 'local',
                        'parameters'        => array(
                            'workspace' => 'workspace'
                        ),
                        'reference_pattern' => 'heads/*'
                    )
                )
            )
        );

        // Get model manager
        $modelManager = $this->getContainer()
            ->get('birgit.model_manager');

        $projects = array();

        foreach ($projectsDefinitions as $projectName => $projectParameters) {
            $projects[$projectName] = $modelManager
                ->getProjectRepository()
                ->create(
                    $projectName,
                    $projectParameters['type'],
                    new Parameters($projectParameters['parameters'])
                )
                    ->setActive($projectParameters['active']);

            $modelManager
                ->getProjectRepository()
                ->save($projects[$projectName]);

            $projectEnvironments = array();

            foreach ($projectParameters['environments'] as $projectEnvironmentName => $projectEnvironmentParameters) {
                $projectEnvironments[$projectEnvironmentName] = $modelManager
                    ->getProjectEnvironmentRepository()
                    ->create(
                        $projectEnvironmentName,
                        $projects[$projectName],
                        $projectEnvironmentParameters['type'],
                        new Parameters($projectEnvironmentParameters['parameters'])
                    )
                        ->setReferencePattern($projectEnvironmentParameters['reference_pattern'])
                        ->setActive($projectEnvironmentParameters['active']);

                $modelManager
                    ->getProjectEnvironmentRepository()
                    ->save($projectEnvironments[$projectEnvironmentName]);
            }
        }
    }
}
