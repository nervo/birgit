<?php

namespace Birgit\Core\Task\Queue\Type;

use Birgit\Component\Task\Queue\Type\TaskQueueType as BaseTaskQueueType;
use Birgit\Core\Project\ProjectManager;
use Birgit\Core\Model\ModelRepositoryManager;

/**
 * Task Queue Type
 */
abstract class TaskQueueType extends BaseTaskQueueType
{
    /**
     * Model Repository Manager
     *
     * @var ModelRepositoryManager
     */
    protected $modelRepositoryManager;

    /**
     * Project Manager
     *
     * @var ProjectManager
     */
    protected $projectManager;

    /**
     * Constructor
     *
     * @param ModelRepositoryManager $modelRepositoryManager
     * @param ProjectManager         $projectManager
     */
    public function __construct(
        ModelRepositoryManager $modelRepositoryManager,
        ProjectManager $projectManager
    ) {
        // Model repository manager
        $this->modelRepositoryManager = $modelRepositoryManager;

        // Project manager
        $this->projectManager = $projectManager;
    }
}
