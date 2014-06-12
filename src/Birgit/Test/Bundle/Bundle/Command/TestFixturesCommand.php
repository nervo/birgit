<?php

namespace Birgit\Test\Bundle\Bundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Birgit\Component\Type\TypeDefinition;

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
                        //'path' => '~/workspace/birgit-test'
                        'path' => 'git@github.com:nervo/birgit-test.git'
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
                        'reference_pattern' => 'heads/master',
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
                        //'path' => '~/workspace/elao/adele'
                        'path' => 'git@github.com:Elao/adele.git'
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

        // Get model repository manager
        $modelRepositoryManager = $this->getContainer()
            ->get('birgit.model_repository_manager');

        $projects = [];

        foreach ($projectsDefinitions as $projectName => $projectParameters) {
            $projects[$projectName] = $modelRepositoryManager
                ->getProjectRepository()
                ->create(
                    $projectName,
                    new TypeDefinition(
                        $projectParameters['handler']['type'],
                        $projectParameters['handler']['parameters']
                    )
                )
                    ->setActive($projectParameters['active']);

            $modelRepositoryManager
                ->getProjectRepository()
                ->save($projects[$projectName]);

            $projectEnvironments = [];

            foreach ($projectParameters['environments'] as $projectEnvironmentName => $projectEnvironmentParameters) {
                $projectEnvironments[$projectEnvironmentName] = $modelRepositoryManager
                    ->getProjectEnvironmentRepository()
                    ->create(
                        $projectEnvironmentName,
                        $projects[$projectName],
                        new TypeDefinition(
                            $projectEnvironmentParameters['handler']['type'],
                            $projectEnvironmentParameters['handler']['parameters']
                        )
                    )
                        ->setReferencePattern($projectEnvironmentParameters['reference_pattern'])
                        ->setActive($projectEnvironmentParameters['active']);

                $modelRepositoryManager
                    ->getProjectEnvironmentRepository()
                    ->save($projectEnvironments[$projectEnvironmentName]);
            }
        }
    }
}
