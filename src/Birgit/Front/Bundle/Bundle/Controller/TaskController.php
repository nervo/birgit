<?php

namespace Birgit\Front\Bundle\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\JsonResponse;

class TaskController extends Controller
{
    /**
     * Index
     * 
     * @Route("/task")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * Index Json
     *
     * @Route("/task.json")
     */
    public function indexJsonAction()
    {
        $links = array();

        $taskQueues = $this->get('birgit.task_queue_repository')
            ->all();

        foreach ($taskQueues as $taskQueue) {

            foreach ($taskQueue->getPredecessors() as $predecessor) {
                $links[] = array(
                    'source' => substr($predecessor->getId(), 0, 8),
                    'target' => substr($taskQueue->getId(), 0, 8),
                    'type'   => 'predecessor'
                );
            }

            foreach ($taskQueue->getSuccessors() as $successor) {
                $links[] = array(
                    'source' => substr($taskQueue->getId(), 0, 8),
                    'target' => substr($successor->getId(), 0, 8),
                    'type'   => 'successor'
                );
            }

        }

        return new JsonResponse($links);
    }
}
