<?php

namespace Birgit\Entity;

use Doctrine\ORM\Mapping as ORM;

use Birgit\Entity\Project;

/**
 * Host
 *
 * @ORM\Table(
 *     name="host"
 * )
 * @ORM\Entity(
 *     repositoryClass="Birgit\Entity\HostRepository"
 * )
 */
class Host
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
     * Host provider
     *
     * @var HostProvider
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\HostProvider",
     *     inversedBy="hosts"
     * )
     * @ORM\JoinColumn(
     *     name="host_provider_id",
     *     nullable=false
     * )
     */
    private $hostProvider;

    /**
     * Project branch
     *
     * @var Project\Branch
     *
     * @ORM\ManyToOne(
     *     targetEntity="Birgit\Entity\Project\Branch",
     *     inversedBy="hosts"
     * )
     * @ORM\JoinColumn(
     *     name="project_branch_id",
     *     nullable=false
     * )
     */
    private $projectBranch;

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
     * Set host provider
     *
     * @param HostProvider $hostProvider
     *
     * @return Project
     */
    public function setHostProvider(HostProvider $hostProvider)
    {
        $this->hostProvider = $hostProvider;

        return $this;
    }

    /**
     * Get host provider
     *
     * @return HostProvider
     */
    public function getHostProvider()
    {
        return $this->hostProvider;
    }

    /**
     * Set project branch
     *
     * @param Project\Branch $projectBranch
     *
     * @return Host
     */
    public function setProjectBranch(Project\Branch $projectBranch)
    {
        $this->projectBranch = $projectBranch;

        return $this;
    }

    /**
     * Get project branch
     *
     * @return Project\Branch
     */
    public function getProjectBranch()
    {
        return $this->projectBranch;
    }
}
