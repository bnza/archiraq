<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TmpDraftRepository")
 * @ORM\Table(name="draft", schema="tmp")
 */
class TmpDraftEntity implements EntityInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="tmp.seq___draft__id")
     * @var int
     */
    private $id;

    /**
     * @var ContributeEntity
     * @ORM\ManyToOne(targetEntity="ContributeEntity", inversedBy="tmp_drafts")
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
     * @ORM\Column(type="string")
     */
    private $modern_name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $ancient_name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $sbah_no;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $cadastre;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $compiler;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $compilation_date;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $remarks;

    /**
     * @var string
     * @ORM\Column(type="string")
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
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     */
    public function setContribute(ContributeEntity $contribute): void
    {
        $this->contribute = $contribute;
    }

    /**
     * @return string
     */
    public function getEntryId(): ?string
    {
        return $this->entry_id;
    }

    /**
     * @param string $entry_id
     */
    public function setEntryId(string $entry_id): void
    {
        $this->entry_id = $entry_id;
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
     */
    public function setModernName(string $modern_name): void
    {
        $this->modern_name = $modern_name;
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
     */
    public function setAncientName(string $ancient_name): void
    {
        $this->ancient_name = $ancient_name;
    }

    /**
     * @return string
     */
    public function getSbahNo(): ?string
    {
        return $this->sbah_no;
    }

    /**
     * @param string $sbah_reg_no
     */
    public function setSbahNo(string $sbah_reg_no): void
    {
        $this->sbah_no = $sbah_reg_no;
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
     */
    public function setCadastre(string $cadastre): void
    {
        $this->cadastre = $cadastre;
    }

    /**
     * @return string
     */
    public function getCompiler(): ?string
    {
        return $this->compiler;
    }

    /**
     * @param string $compiler
     */
    public function setCompiler(string $compiler): void
    {
        $this->compiler = $compiler;
    }

    /**
     * @return string
     */
    public function getCompilationDate(): ?string
    {
        return $this->compilation_date;
    }

    /**
     * @param string $compilation_date
     */
    public function setCompilationDate(string $compilation_date): void
    {
        $this->compilation_date = $compilation_date;
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
     */
    public function setRemarks(string $remarks): void
    {
        $this->remarks = $remarks;
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
     */
    public function setCredits(string $credits): void
    {
        $this->credits = $credits;
    }

}
