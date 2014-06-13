<?php

namespace Birgit\Api\Bundle\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/task")
 */
class TaskController extends Controller
{
    /**
     * Project
     * 
     * @Route("/project")
     */
    public function projectAction(Request $request)
    {
        // Get project
        $project = $this->get('birgit.model_repository_manager')
            ->getProjectRepository()
            ->get($request->get('name'));

        // Get task manager
        $taskManager = $this->get('birgit.task_manager');

        // Create task queue
        $taskQueue = $taskManager
            ->createProjectTaskQueue($project, [
                'project'
            ]);

        // Push task queue
        $taskManager->pushTaskQueue($taskQueue);

        return new Response();
    }
}
