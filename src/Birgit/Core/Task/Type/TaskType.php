<?php

namespace Birgit\Core\Task\Type;

use Birgit\Component\Task\Type\TaskType as BaseTaskType;
use Birgit\Core\Project\ProjectManager;
use Birgit\Core\Model\ModelRepositoryManager;

/**
 * Task Type
 */
abstract class TaskType extends BaseTaskType
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
