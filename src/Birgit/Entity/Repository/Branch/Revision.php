<?php

namespace Birgit\Entity\Repository\Branch;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

use Birgit\Entity\Repository\Branch;

/**
 * Repository branch revision
 *
 * @ORM\Table(
 *     name="repository_branch_revision"
 * )
 * @ORM\Entity(
 *     repositoryClass="Birgit\Entity\Repository\Branch\RevisionRepository"
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
     * Branch
     *
     * @var Branch
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Repository\Branch",
     *     inversedBy="revisions"
     * )
     * @ORM\JoinColumn(
     *     name="branch_id",
     *     nullable=false
     * )
     */
    private $branch;

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
     * @return Revision
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
     * Set branch
     *
     * @param Branch $branch
     *
     * @return Revision
     */
    public function setBranch(Branch $branch)
    {
        $this->branch = $branch;

        return $this;
    }

    /**
     * Get branch
     *
     * @return Branch
     */
    public function getbranch()
    {
        return $this->branch;
    }
}
