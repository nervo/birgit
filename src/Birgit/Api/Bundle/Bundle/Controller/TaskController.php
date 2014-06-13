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
     * @Route("/project", name="api_task_project")
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

    /**
     * Project Reference
     *
     * @Route("/project/reference", name="api_task_project_reference")
     */
    public function projectReferenceAction(Request $request)
    {
        // Get project
        $project = $this->get('birgit.model_repository_manager')
            ->getProjectRepository()
            ->get($request->get('projectName'));

        // Get project reference
        $projectReference = $this->get('birgit.model_repository_manager')
            ->getProjectReferenceRepository()
            ->get($request->get('name'), $project);

        // Get task manager
        $taskManager = $this->get('birgit.task_manager');

        // Create task queue
        $taskQueue = $taskManager
            ->createProjectReferenceTaskQueue($projectReference, [
                'project_reference'
            ]);

        // Push task queue
        $taskManager->pushTaskQueue($taskQueue);

        return new Response();
    }

    /**
     * Host
     *
     * @Route("/host", name="api_task_host")
     */
    public function hostAction(Request $request)
    {
        // Get host
        $host = $this->get('birgit.model_repository_manager')
            ->getHostRepository()
            ->get($request->get('id'));

        // Get task manager
        $taskManager = $this->get('birgit.task_manager');

        // Create task queue
        $taskQueue = $taskManager
            ->createHostTaskQueue($host, [
                'host'
            ]);

        // Push task queue
        $taskManager->pushTaskQueue($taskQueue);

        return new Response();
    }
}
