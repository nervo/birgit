<?php

namespace Birgit\Domain\Build\Task\Queue\Context;

use Birgit\Domain\Project\Task\Queue\Context\ProjectReferenceTaskQueueContextInterface;
use Birgit\Domain\Project\Task\Queue\Context\ProjectEnvironmentTaskQueueContextInterface;

/**
 * Build Task queue Context Interface
 */
interface BuildTaskQueueContextInterface extends ProjectReferenceTaskQueueContextInterface, ProjectEnvironmentTaskQueueContextInterface
{
}
