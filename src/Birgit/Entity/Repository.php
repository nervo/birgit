<?php

namespace Birgit\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Repository
 *
 * @ORM\Table(
 *     name="repository"
 * )
 * @ORM\Entity(
 *     repositoryClass="Birgit\Entity\RepositoryRepository"
 * )
 */
class Repository
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
     * Url
     *
     * @var string
     *
     * @ORM\Column(
     *     name="url",
     *     type="string", length=255
     * )
     */
    private $url;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity="Birgit\Entity\Project",
     *     mappedBy="repository",
     *     cascade={"persist"}
     * )
     */
    private $projects;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Projects
        $this->projects = new ArrayCollection();
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
     * Set url
     *
     * @param string $url
     *
     * @return Repository
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Add project
     *
     * @param Project $project
     *
     * @return Repository
     */
    public function addProject(Project $project)
    {
        if (!$this->projects->contains($project)) {
            $this->projects->add($project);
            $project->setRepository($this);
        }

        return $this;
    }

    /**
     * Remove project
     *
     * @param Project $project
     *
     * @return Repository
     */
    public function removeProject(Project $project)
    {
        $this->projects->removeElement($project);

        return $this;
    }

    /**
     * Get projects
     *
     * @return Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }
}
