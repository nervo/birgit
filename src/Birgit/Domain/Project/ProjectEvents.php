<?php

namespace Birgit\Domain\Project;

final class ProjectEvents
{
    const STATUS_UP        = 'birgit.project.status_up';
    const STATUS_DOWN      = 'birgit.project.status_down';
    const REFERENCE        = 'birgit.project.reference';
    const REFERENCE_CREATE = 'birgit.project.reference_create';
    const REFERENCE_DELETE = 'birgit.project.reference_delete';
}
