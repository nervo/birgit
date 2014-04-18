<?php

namespace Birgit\Entity\Repository;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Entity\Repository;

/**
 * Repository branch
 *
 * @ORM\Table(
 *     name="repository_branch"
 * )
 * @ORM\Entity(
 *     repositoryClass="Birgit\Entity\Repository\BranchRepository"
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
     * Repository
     *
     * @var Repository
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Repository",
     *     inversedBy="branches"
     * )
     * @ORM\JoinColumn(
     *     name="repository_id",
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
     *     targetEntity="Birgit\Entity\Repository\Branch\Revision",
     *     mappedBy="branch",
     *     cascade={"persist"}
     * )
     */
    private $revisions;

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
     * Set repository
     *
     * @param Repository $repository
     *
     * @return Branch
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
     * @param Branch\Revision $revision
     *
     * @return Branch
     */
    public function addRevision(Branch\Revision $revision)
    {
        if (!$this->revisions->contains($revision)) {
            $this->revisions->add($revision);
            $revision->setBRanch($this);
        }

        return $this;
    }

    /**
     * Remove revision
     *
     * @param Branch\Revision $revision
     */
    public function removeRevision(Branch\Revision $revision)
    {
        $this->revisions->removeElement($revision);
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
}
