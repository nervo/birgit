<?php

namespace Birgit\Model;

/**
 * Model Manager Interface
 */
interface ModelManagerInterface
{
    /**
     * Get build repository
     * 
     * @return Build\BuildRepository
     */
    public function getBuildRepository();
    
    /**
     * Get host repository
     * 
     * @return Host\HostRepository
     */
    public function getHostRepository();
    
    /**
     * Get project repository
     * 
     * @return Project\ProjectRepository
     */
    public function getProjectRepository();

    /**
     * Get project environment repository
     * 
     * @return Project\Environment\ProjectEnvironmentRepository
     */
    public function getProjectEnvironmentRepository();
    
    /**
     * Get project reference repository
     * 
     * @return Project\Reference\ProjectReferenceRepository
     */
    public function getProjectReferenceRepository();

    /**
     * Get project reference revision repository
     * 
     * @return Project\Reference\Revision\ProjectReferenceRevisionRepository
     */
    public function getProjectReferenceRevisionRepository();
    
    /**
     * Get task repository
     * 
     * @return Task\TaskRepository
     */
    public function getTaskRepository();
    
    /**
     * Get task queue repository
     * 
     * @return Task\Queue\TaskQueueRepository
     */
    public function getTaskQueueRepository();
}
