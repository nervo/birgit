<?php

namespace Birgit\Domain\Project\Task\Handler;

use Birgit\Domain\Task\Queue\Context\TaskQueueContextInterface;
use Birgit\Model\Task\Task;
use Birgit\Component\Parameters\Parameters;
use Birgit\Domain\Handler\HandlerDefinition;
use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContextInterface;
use Birgit\Domain\Exception\Context\ContextException;

/**
 * Project reference Task handler
 */
class ProjectReferenceTaskHandler extends ProjectTaskHandler
{
    public function getType()
    {
        return 'project_reference';
    }

    public function run(Task $task, TaskQueueContextInterface $context)
    {
        if (!$context instanceof ProjectReferenceTaskQueueContextInterface) {
            throw new ContextException();
        }

        // Get project reference
        $projectReference = $context->getProjectReference();

        // Get project handler
        $projectHandler = $this->handlerManager
            ->getProjectHandler(
                $projectReference->getProject()
            );

        // Get "real life" project reference revision
        $projectHandlerReferenceRevisionName = $projectHandler->getReferenceRevision(
            $projectReference,
            $context
        );

        // Find project reference revisions
        $projectReferenceRevisionFound = false;
        foreach ($projectReference->getRevisions() as $projectReferenceRevision) {
            if ($projectReferenceRevision->getName() === $projectHandlerReferenceRevisionName) {
                $projectReferenceRevisionFound = true;
                break;
            }
        }

        if ($projectReferenceRevisionFound) {
            $taskQueue = $this->modelManager
                ->getTaskQueueRepository()
                ->create(
                    new HandlerDefinition(
                        'project_reference_revision',
                        new Parameters(array(
                            'project_name'                    => $projectReference->getProject()->getName(),
                            'project_reference_name'          => $projectReference->getName(),
                            'project_reference_revision_name' => $projectHandlerReferenceRevisionName
                        ))
                    )
                );

            $this->handlerManager
                ->getTaskQueueHandler($taskQueue)
                    ->run($taskQueue);
        } else {

            $taskQueue = $this->modelManager
                ->getTaskQueueRepository()
                ->create(
                    new HandlerDefinition(
                        'project_reference_revision_create',
                        new Parameters(array(
                            'project_name'                    => $projectReference->getProject()->getName(),
                            'project_reference_name'          => $projectReference->getName(),
                            'project_reference_revision_name' => $projectHandlerReferenceRevisionName
                        ))
                    )
                );

            $this->handlerManager
                ->getTaskQueueHandler($taskQueue)
                    ->run($taskQueue);
        }
    }
}
