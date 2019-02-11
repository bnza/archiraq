<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 04/02/19
 * Time: 18.47
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SiteRepository")
 * @ORM\Table(name="site", schema="public")
 * @UniqueEntity(
 *      fields={"contribute_id", "entry_id"},
 *      message="Duplicate entry id {{ value }} for this contribute"
 * )
 * @UniqueEntity(
 *      fields={"sbah_reg_no"},
 *      message="Duplicate SBAH {{ value }}",
 * )
 */
class SiteEntity implements EntityInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="public.seq___site__id")
     * @var int
     */
    private $id;

    /**
     * @var ContributeEntity
     * @ORM\ManyToOne(targetEntity="ContributeEntity", inversedBy="sites")
     * @ORM\JoinColumn(name="contribute_id", referencedColumnName="id", nullable=false, onDelete="NO ACTION")
     */
    private $contribute;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $entry_id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $modern_name;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nearest_city;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ancient_name;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $ancient_name_uncertain;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sbah_no;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cadastre;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $compiler;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @ORM\Column(type="date")
     */
    private $compilation_date;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $remarks;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private $credits;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return SiteEntity
     */
    public function setId(int $id): SiteEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return ContributeEntity
     */
    public function getContribute(): ContributeEntity
    {
        return $this->contribute;
    }

    /**
     * @param ContributeEntity $contribute
     * @return SiteEntity
     */
    public function setContribute(ContributeEntity $contribute): SiteEntity
    {
        $this->contribute = $contribute;
        return $this;
    }

    /**
     * @return string
     */
    public function getEntryId(): string
    {
        return $this->entry_id;
    }

    /**
     * @param string $entry_id
     * @return SiteEntity
     */
    public function setEntryId(string $entry_id): SiteEntity
    {
        $this->entry_id = $entry_id;
        return $this;
    }

    /**
     * @return string
     */
    public function getNearestCity(): ?string
    {
        return $this->nearest_city;
    }

    /**
     * @param string $nearest_city
     * @return SiteEntity
     */
    public function setNearestCity(string $nearest_city): SiteEntity
    {
        $this->nearest_city = $nearest_city;
        return $this;
    }

    /**
     * @return string
     */
    public function getModernName(): ?string
    {
        return $this->modern_name;
    }

    /**
     * @param string $modern_name
     * @return SiteEntity
     */
    public function setModernName(string $modern_name): SiteEntity
    {
        $this->modern_name = $modern_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getAncientName(): ?string
    {
        return $this->ancient_name;
    }

    /**
     * @param string $ancient_name
     * @return SiteEntity
     */
    public function setAncientName(?string $ancient_name): SiteEntity
    {
        $this->ancient_name = $ancient_name;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAncientNameUncertain(): ?bool
    {
        return $this->ancient_name_uncertain;
    }

    /**
     * @param bool $ancient_name_uncertain
     * @return SiteEntity
     */
    public function setAncientNameUncertain(?bool $ancient_name_uncertain): SiteEntity
    {
        $this->ancient_name_uncertain = $ancient_name_uncertain;
        return $this;
    }

    /**
     * @return string
     */
    public function getSbahNo(): ?string
    {
        return $this->sbah_no;
    }

    /**
     * @param string $sbah_no
     * @return SiteEntity
     */
    public function setSbahNo(?string $sbah_no): SiteEntity
    {
        $this->sbah_no = $sbah_no;
        return $this;
    }

    /**
     * @return string
     */
    public function getCadastre(): ?string
    {
        return $this->cadastre;
    }

    /**
     * @param string $cadastre
     * @return SiteEntity
     */
    public function setCadastre(?string $cadastre): SiteEntity
    {
        $this->cadastre = $cadastre;
        return $this;
    }

    /**
     * @return string
     */
    public function getCompiler(): string
    {
        return $this->compiler;
    }

    /**
     * @param string $compiler
     * @return SiteEntity
     */
    public function setCompiler(string $compiler): SiteEntity
    {
        $this->compiler = $compiler;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCompilationDate(): \DateTime
    {
        return $this->compilation_date;
    }

    /**
     * @param \DateTime $compilation_date
     * @return SiteEntity
     */
    public function setCompilationDate(\DateTime $compilation_date): SiteEntity
    {
        $this->compilation_date = $compilation_date;
        return $this;
    }

    /**
     * @return string
     */
    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    /**
     * @param string $remarks
     * @return SiteEntity
     */
    public function setRemarks(?string $remarks): SiteEntity
    {
        $this->remarks = $remarks;
        return $this;
    }

    /**
     * @return string
     */
    public function getCredits(): ?string
    {
        return $this->credits;
    }

    /**
     * @param string $credits
     * @return SiteEntity
     */
    public function setCredits(?string $credits): SiteEntity
    {
        $this->credits = $credits;
        return $this;
    }

}
