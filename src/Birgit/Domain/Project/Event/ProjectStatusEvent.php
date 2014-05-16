<?php

namespace Birgit\Domain\Project\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Project Status Event
 */
class ProjectStatusEvent extends Event
{
    protected $name;
    protected $status;

    public function __construct($name, $status)
    {
        $this->name = $name;
        $this->status = $status;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getStatus()
    {
        return $this->status;
    }
}
