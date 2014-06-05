<?php

namespace Birgit\Front\Bundle\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProjectController extends Controller
{
    /**
     * @Route("/project/{name}")
     * @Template()
     */
    public function indexAction($name)
    {
        // Get model repository manager
        $modelRepositoryManager = $this->get('birgit.model_repository_manager');

        // Get project repository
        $projectRepository = $modelRepositoryManager
            ->getProjectRepository();

        $project = $projectRepository->get($name);

        return array('project' => $project);
    }
}
