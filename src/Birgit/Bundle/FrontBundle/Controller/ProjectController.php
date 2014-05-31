<?php

namespace Birgit\Bundle\FrontBundle\Controller;

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
        // Get model manager
        $modelManager = $this->get('birgit.model_manager');

        // Get project repository
        $projectRepository = $modelManager
                ->getProjectRepository();

        $project = $projectRepository->get($name);

        return array('project' => $project);
    }
}
