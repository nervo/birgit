<?php

namespace Birgit\Bundle\ProjectBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

use Birgit\Bundle\RepositoryBundle\Entity\Repository;

/**
 * Project
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Birgit\Bundle\ProjectBundle\Entity\ProjectRepository")
 */
class Project
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
     * @var Repository
     *
     * @ORM\ManyToOne(targetEntity="Birgit\Bundle\RepositoryBundle\Entity\Repository", inversedBy="projects")
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
     * @return Project
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
