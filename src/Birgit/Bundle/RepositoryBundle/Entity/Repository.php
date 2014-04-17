<?php

namespace Birgit\Bundle\RepositoryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Bundle\ProjectBundle\Entity\Project;

/**
 * Repository
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Birgit\Bundle\RepositoryBundle\Entity\RepositoryRepository")
 */
class Repository
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Birgit\Bundle\RepositoryBundle\Entity\Repository\Branch", mappedBy="repository")
     */
    private $branches;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Birgit\Bundle\ProjectBundle\Entity\Project", mappedBy="repository")
     */
    private $projects;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
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
     * Add branch
     *
     * @param Branch $branch
     *
     * @return Repository
     */
    public function addBranch(Branch $branch)
    {
        $this->branches[] = $branch;

        return $this;
    }

    /**
     * Remove branch
     *
     * @param Branch $branch
     */
    public function removeBranch(Branch $branch)
    {
        $this->branches->removeElement($branch);
    }

    /**
     * Get branches
     *
     * @return Collection
     */
    public function getBranches()
    {
        return $this->branches;
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
        $this->projects[] = $project;

        return $this;
    }

    /**
     * Remove project
     *
     * @param Project $project
     */
    public function removeProject(Project $project)
    {
        $this->projects->removeElement($project);
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
