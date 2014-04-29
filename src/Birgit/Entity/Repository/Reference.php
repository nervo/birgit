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
 *     uniqueConstraints={@ORM\UniqueConstraint(name="repository_id_type_name",columns={"repository_id", "type", "name"})}
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
     *     name="id",
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
     *     name="name",
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
     *     name="repository_id",
     *     nullable=false
     * )
     */
    private $repository;

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
