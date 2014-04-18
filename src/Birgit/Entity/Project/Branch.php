<?php

namespace Birgit\Entity\Project;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Entity\Project;
use Birgit\Entity\Host;

/**
 * Project branch
 *
 * @ORM\Table(
 *     name="project_branch"
 * )
 * @ORM\Entity(
 *     repositoryClass="Birgit\Entity\Project\BranchRepository"
 * )
 */
class Branch
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
     * Revision
     *
     * @var string
     *
     * @ORM\Column(
     *     name="revision",
     *     type="string",
     *     length=255
     * )
     */
    private $revision;

    /**
     * Project
     *
     * @var Project
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Project",
     *     inversedBy="branches"
     * )
     * @ORM\JoinColumn(
     *     name="project_id",
     *     nullable=false
     * )
     */
    private $project;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Host",
     *     mappedBy="projectBranch",
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
     * @return Branch
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Set revision
     *
     * @param string $revision
     *
     * @return Branch
     */
    public function setRevision($revision)
    {
        $this->revision = $revision;

        return $this;
    }

    /**
     * Get revision
     *
     * @return string
     */
    public function getRevision()
    {
        return $this->revision;
    }

    /**
     * Set project
     *
     * @param Project $project
     *
     * @return Branch
     */
    public function setProject(Project $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Add host
     *
     * @param Host $host
     *
     * @return Branch
     */
    public function addHost(Host $host)
    {
        if (!$this->hosts->contains($host)) {
            $this->hosts->add($host);
            $host->setProjectBranch($this);
        }

        return $this;
    }

    /**
     * Remove host
     *
     * @param Host $host
     *
     * @return Branch
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
