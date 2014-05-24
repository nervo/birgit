<?php

namespace Birgit\Domain\Handler;

/**
 * Handleable
 */
interface Handleable
{
    /**
     * Get Handler Definition
     *
     * @return HandlerDefinition
     */
    public function getHandlerDefinition();
}
