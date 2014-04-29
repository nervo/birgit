<?php

namespace Birgit\Entity\Repository\Reference;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Entity\Repository\Reference;
use Birgit\Entity\Host;
use Birgit\Entity\Build;

/**
 * Repository reference revision
 *
 * @ORM\Table(
 *     name="repository_reference_revision"
 * )
 * @ORM\Entity(
 *     repositoryClass="Birgit\Entity\Repository\Reference\RevisionRepository"
 * )
 */
class Revision
{
    /**
     * Id
     *
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(
     *     type="integer"
     * )
     * @ORM\GeneratedValue(
     *     strategy="AUTO"
     * )
     */
    private $id;

    /**
     * Hash
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255
     * )
     */
    private $hash;

    /**
     * Reference
     *
     * @var Reference
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Repository\Reference",
     *     inversedBy="revisions"
     * )
     * @ORM\JoinColumn(
     *     nullable=false
     * )
     */
    private $reference;

    /**
     * Builds
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Build",
     *     mappedBy="repositoryReferenceRevision",
     *     cascade={"persist"}
     * )
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
     * Set hash
     *
     * @param string $hash
     *
     * @return Revision
     */
    public function setHash($hash)
    {
        $this->hash = (string) $hash;

        return $this;
    }

    /**
     * Get hash
     *
     * @return string
     */
    public function getHash()
    {
    	return $this->hash;
    }

    /**
     * Set reference
     *
     * @param Reference $reference
     *
     * @return Revision
     */
    public function setReference(Reference $reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return Reference
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Add build
     *
     * @param Build $build
     *
     * @return Revision
     */
    public function addBuild(Build $build)
    {
        if (!$this->builds->contains($build)) {
            $this->builds->add($build);
            $build->setRepositoryReferenceRevision($this);
        }

        return $this;
    }

    /**
     * Remove build
     *
     * @param Build $build
     *
     * @return Revision
     */
    public function removeBuild(Build $build)
    {
        $this->builds->removeElement($build);

        return $this;
    }

    /**
     * Get builds
     *
     * @return Collection
     */
    public function getBuilds()
    {
        return $this->builds;
    }
}
