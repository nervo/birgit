<?php

namespace Birgit\Bundle\DoctrineBundle\Entity\Project\Reference\Revision;

use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Core\Model;

/**
 * Project reference revision
 */
class ProjectReferenceRevision extends Model\Project\Reference\Revision\ProjectReferenceRevision
{
    /**
     * Id
     *
     * @var int
     */
    private $id;

    /**
     * Name
     *
     * @var string
     */
    private $name;

    /**
     * Reference
     *
     * @var Model\Project\Reference\ProjectReference
     */
    private $reference;

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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return ProjectReferenceRevision
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set reference
     *
     * @param ProjectReference $reference
     *
     * @return ProjectReferenceRevision
     */
    public function setReference(Model\Project\Reference\ProjectReference $reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * {@inheritdoc}
     */
    public function addBuild(Model\Build\Build $build)
    {
        if (!$this->builds->contains($build)) {
            $this->builds->add($build);
            $build->setProjectReferenceRevision($this);
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
