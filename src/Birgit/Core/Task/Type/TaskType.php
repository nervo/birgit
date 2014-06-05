<?php

namespace Birgit\Core\Task\Type;

use Birgit\Component\Task\Type\TaskType as BaseTaskType;
use Birgit\Core\Project\ProjectManager;
use Birgit\Core\Model\ModelRepositoryManager;
use Birgit\Component\Task\TaskManager;

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
     * Task Manager
     *
     * @var TaskManager
     */
    protected $taskManager;

    /**
     * Constructor
     *
     * @param ModelRepositoryManager $modelRepositoryManager
     * @param ProjectManager         $projectManager
     * @param TaskManager            $taskManager
     */
    public function __construct(
        ModelRepositoryManager $modelRepositoryManager,
        ProjectManager $projectManager,
        TaskManager $taskManager
    ) {
        // Model repository manager
        $this->modelRepositoryManager = $modelRepositoryManager;

        // Project manager
        $this->projectManager = $projectManager;

        // Task manager
        $this->taskManager = $taskManager;
    }
}
