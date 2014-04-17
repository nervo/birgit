<?php

namespace Birgit\Bundle\RepositoryBundle\Entity\Repository;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Bundle\RepositoryBundle\Entity\Repository;

/**
 * Branch
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Birgit\Bundle\RepositoryBundle\Entity\Repository\BranchRepository")
 */
class Branch
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var revision
     *
     * @ORM\Column(name="revision", type="string", length=255)
     */
    private $revision;

    /**
     * @var Repository
     *
     * @ORM\ManyToOne(targetEntity="Birgit\Bundle\RepositoryBundle\Entity\Repository", inversedBy="branches")
     * @ORM\JoinColumn(nullable=false)
     */
    private $repository;

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
     * Set name
     *
     * @param string $name
     *
     * @return Repository
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
     * @return Repository
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
     * Set repository
     *
     * @param Repository $repository
     *
     * @return Project
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
}
