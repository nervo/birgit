<?php

namespace Birgit\Component\Repository\Reference\Task;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

use Doctrine\Common\Persistence\ManagerRegistry;

use Birgit\Component\Task\Task;
use Birgit\Component\Task\TaskContext;
use Birgit\Component\Task\TaskParameters;
use Birgit\Component\Repository\RepositoryManager;
use Birgit\Component\Repository\RepositoryContext;
use Birgit\Component\Repository\Reference\RepositoryReferenceEvents;
use Birgit\Component\Repository\Reference\Event\RepositoryReferenceCreationEvent;
use Birgit\Component\Repository\Reference\Event\RepositoryReferenceDeletionEvent;

/**
 * Repository reference Check Task
 */
class RepositoryReferenceCheckTask extends Task
{
    protected $repositoryManager;

    protected $doctrineManagerRegistry;

    protected $eventDispatcher;

    public function __construct(RepositoryManager $repositoryManager, ManagerRegistry $doctrineManagerRegistry, EventDispatcherInterface $eventDispatcher)
    {
        $this->repositoryManager = $repositoryManager;

        $this->doctrineManagerRegistry = $doctrineManagerRegistry;

        $this->eventDispatcher = $eventDispatcher;
    }

    public function execute(TaskContext $context, TaskParameters $parameters = null)
    {
        // Log
        $context->getLogger()->notice('Task: Repository Reference Check');

        // Get repository entities
        $repositoryEntities = $this->doctrineManagerRegistry
            ->getRepository('Birgit:Repository')
            ->findAll();

        foreach ($repositoryEntities as $repositoryEntity) {

            // Log
            $context->getLogger()->info(sprintf('Handle Repository id "%s"', $repositoryEntity->getId()));

            $repository = $this->repositoryManager
                ->getRepositoryType($repositoryEntity->getType());

            $repositoryParametersClass = $repository->getParametersClass();
            $repositoryParameters = (new $repositoryParametersClass())
                ->merge($repositoryEntity->getParameters());

            $repositoryContext = new RepositoryContext(
                $context->getLogger()
            );

            $repositoryReferences = $repository->getReferences(
                $repositoryContext,
                $repositoryParameters
            );

            // Find created repository references
            foreach ($repositoryReferences as $repositoryReferenceName => $repositoryReferenceRevision) {
                $repositoryReferenceFound = false;
                foreach ($repositoryEntity->getReferences() as $repositoryReferenceEntity) {
                    if ($repositoryReferenceEntity->getName === $repositoryReferenceName) {
                        $repositoryReferenceFound = true;
                        break;
                    }
                }
                if (!$repositoryReferenceFound) {
                    // Log
                    $context->getLogger()->info(sprintf('Repository reference name "%s" revision "%s" creation', $repositoryReferenceName, $repositoryReferenceRevision));

                    $this->eventDispatcher
                        ->dispatch(
                            RepositoryReferenceEvents::CREATION,
                            new RepositoryReferenceCreationEvent($repositoryReferenceName, $repositoryReferenceRevision)
                        );
                }
            }

            // Find deleted repository references
            foreach ($repositoryEntity->getReferences() as $repositoryReferenceEntity) {
                $repositoryReferenceFound = false;
                foreach ($repositoryReferences as $repositoryReferenceName => $repositoryReferenceRevision) {
                    if ($repositoryReferenceEntity->getName === $repositoryReferenceName) {
                        $repositoryReferenceFound = true;
                        break;
                    }
                }
                if (!$repositoryReferenceFound) {
                    // Log
                    $context->getLogger()->info(sprintf('Repository reference name "%s" revision "%s" deletion', $repositoryReferenceName, $repositoryReferenceRevision));

                    $this->eventDispatcher
                        ->dispatch(
                            RepositoryReferenceEvents::DELETION,
                            new RepositoryReferenceDeletionEvent($repositoryReferenceName, $repositoryReferenceRevision)
                        );
                }
            }
        }
    }
}
