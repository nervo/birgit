<?php

namespace Birgit\Domain\Project;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Project EventListener
 */
class ProjectEventListener implements EventSubscriberInterface
{
    protected $projectManager;

    public function __construct(ProjectManager $projectManager)
    {
        $this->projectManager = $projectManager;
    }

    public static function getSubscribedEvents()
    {
        return array(
            ProjectEvents::STATUS => 'onProjectStatus'
        );
    }

    public function onProjectStatus(Event\ProjectStatusEvent $event)
    {
    }
}
