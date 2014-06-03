<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Host;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Model;

/**
 * Host
 */
class Host extends Model\Host\Host
{
    /**
     * Id
     *
     * @var string
     */
    private $id;

    /**
     * Project reference
     *
     * @var Model\Project\Reference\ProjectReference
     */
    private $projectReference;

    /**
     * Project environment
     *
     * @var Model\Project\Environment\ProjectEnvironment
     */
    private $projectEnvironment;

    /**
     * Builds
     *
     * @var ArrayCollection
     */
    private $builds;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Builds
        $this->builds = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set project reference
     *
     * @param ProjectReference $projectReference
     *
     * @return Host
     */
    public function setProjectReference(Model\Project\Reference\ProjectReference $projectReference)
    {
        $this->projectReference = $projectReference;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectReference()
    {
        return $this->projectReference;
    }

    /**
     * Set project environment
     *
     * @param ProjectEnvironment $projectEnvironment
     *
     * @return Host
     */
    public function setProjectEnvironment(Model\Project\Environment\ProjectEnvironment $projectEnvironment)
    {
        $this->projectEnvironment = $projectEnvironment;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getProjectEnvironment()
    {
        return $this->projectEnvironment;
    }

    /**
     * {@inheritdoc}
     */
    public function addBuild(Model\Build\Build $build)
    {
        if (!$this->builds->contains($build)) {
            $this->builds->add($build);
            $build->setHost($this);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeBuild(Model\Build\Build $build)
    {
        $this->builds->removeElement($build);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getBuilds()
    {
        return $this->builds;
    }
}
