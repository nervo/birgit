<?php

namespace Birgit\Entity\Repository;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Entity\Project;
use Birgit\Entity\Host;
use Birgit\Entity\Build;
use Birgit\Entity\Repository;

/**
 * Repository reference
 *
 * @ORM\Table(
 *     name="repository_reference",
 *     uniqueConstraints={@ORM\UniqueConstraint(name="repository_id_name",columns={"repository_id", "name"})}
 * )
 * @ORM\Entity(
 *     repositoryClass="Birgit\Entity\Repository\ReferenceRepository"
 * )
 */
class Reference
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
     * Name
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255
     * )
     */
    private $name;

    /**
     * Repository
     *
     * @var Repository
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Repository",
     *     inversedBy="references"
     * )
     * @ORM\JoinColumn(
     *     nullable=false
     * )
     */
    private $repository;

    /**
     * Revisions
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Repository\Reference\Revision",
     *     mappedBy="reference",
     *     cascade={"persist"}
     * )
     */
    private $revisions;

    /**
     * Hosts
     *
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Host",
     *     mappedBy="repositoryReference",
     *     cascade={"persist"}
     * )
     */
    private $hosts;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Revisions
        $this->revisions = new ArrayCollection();

        // Hosts
        $this->hosts = new ArrayCollection();
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
     * @return Reference
     */
    public function setName($name)
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
    	return $this->name;
    }

    /**
     * Set repository
     *
     * @param Repository $repository
     *
     * @return Reference
     */
    public function setRepository(Repository $repository)
    {
        $this->repository = $repository;

        return $this;
    }

    /**
     * Get repository
     *
     * @return Repository
     */
    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * Add revision
     *
     * @param Reference\Revision $revision
     *
     * @return Reference
     */
    public function addRevision(Reference\Revision $revision)
    {
        if (!$this->revisions->contains($revision)) {
            $this->revisions->add($revision);
            $revision->setReference($this);
        }

        return $this;
    }

    /**
     * Remove revision
     *
     * @param Reference\Revision $revision
     *
     * @return Reference
     */
    public function removeRevision(Reference\Revision $revision)
    {
        $this->revisions->removeElement($revision);

        return $this;
    }

    /**
     * Get revisions
     *
     * @return Collection
     */
    public function getRevisions()
    {
        return $this->revisions;
    }

    /**
     * Add host
     *
     * @param Host $host
     *
     * @return Reference
     */
    public function addHost(Host $host)
    {
        if (!$this->hosts->contains($host)) {
            $this->hosts->add($host);
            $host->setRepositoryReference($this);
        }

        return $this;
    }

    /**
     * Remove host
     *
     * @param Host $host
     *
     * @return Reference
     */
    public function removeHost(Host $host)
    {
        $this->hosts->removeElement($host);

        return $this;
    }

    /**
     * Get hosts
     *
     * @return Collection
     */
    public function getHosts()
    {
        return $this->hosts;
    }
}
