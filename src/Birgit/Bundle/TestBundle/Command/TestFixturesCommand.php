<?php

namespace Birgit\Bundle\TestBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Birgit\Domain\Handler\HandlerDefinition;
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
        $projectsDefinitions = [
            'test'  => [
                'active'       => true,
                'handler'      => [
                    'type'       => 'git',
                    'parameters' => [
                        //'path' => 'git@github.com:nervo/birgit-test.git'
                        'path' => '~/workspace/birgit-test'
                    ]
                ],
                'environments' => [
                    'test'    => [
                        'active'            => true,
                        'reference_pattern' => 'heads/*',
                        'handler'           => [
                            'type'       => 'local',
                            'parameters' => [
                                'workspace' => 'workspace'
                            ]
                        ]
                    ],
                    'quality' => [
                        'active'            => true,
                        'reference_pattern' => 'heads/*',
                        'handler'           => [
                            'type'       => 'local',
                            'parameters' => [
                                'workspace' => 'workspace'
                            ]
                        ]
                    ]
                ]
            ],
            'adele' => [
                'active'       => true,
                'handler'      => [
                    'type'       => 'git',
                    'parameters' => [
                        //'path' => 'git@github.com:Elao/adele.git'
                        'path' => '~/workspace/elao/adele'
                    ]
                ],
                'environments' => [
                    'test'    => [
                        'active'            => true,
                        'reference_pattern' => 'heads/*',
                        'handler'           => [
                            'type'       => 'local',
                            'parameters' => [
                                'workspace' => 'workspace'
                            ]
                        ]
                    ],
                    'quality' => [
                        'active'            => true,
                        'reference_pattern' => 'heads/*',
                        'handler'           => [
                            'type'              => 'local',
                            'parameters'        => [
                                'workspace' => 'workspace'
                            ]
                        ]
                    ],
                    'demo'    => [
                        'active'            => true,
                        'reference_pattern' => 'heads/*',
                        'handler'           => [
                            'type'              => 'local',
                            'parameters'        => [
                                'workspace' => 'workspace'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        // Get model manager
        $modelManager = $this->getContainer()
            ->get('birgit.model_manager');

        $projects = [];

        foreach ($projectsDefinitions as $projectName => $projectParameters) {
            $projects[$projectName] = $modelManager
                ->getProjectRepository()
                ->create(
                    $projectName,
                    new HandlerDefinition(
                        $projectParameters['handler']['type'],
                        new Parameters($projectParameters['handler']['parameters'])
                    )
                )
                    ->setActive($projectParameters['active']);

            $modelManager
                ->getProjectRepository()
                ->save($projects[$projectName]);

            $projectEnvironments = [];

            foreach ($projectParameters['environments'] as $projectEnvironmentName => $projectEnvironmentParameters) {
                $projectEnvironments[$projectEnvironmentName] = $modelManager
                    ->getProjectEnvironmentRepository()
                    ->create(
                        $projectEnvironmentName,
                        $projects[$projectName],
                        new HandlerDefinition(
                            $projectEnvironmentParameters['handler']['type'],
                            new Parameters($projectEnvironmentParameters['handler']['parameters'])
                        )
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
