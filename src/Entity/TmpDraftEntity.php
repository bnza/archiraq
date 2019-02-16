<?php

namespace App\Entity;

use App\Validator\Constraints as AppAssert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     *
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
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="TmpDraftErrorEntity", mappedBy="draft", cascade={"persist", "remove"})
     */
    private $errors;

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
     * @AppAssert\ContainsValidChronologyCodes
     */
    private $site_chronology;

    /**
     * @var string
     * @ORM\Column(type="string")
     * @AppAssert\ContainsValidDistrictName
     */
    private $district;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $features_epigraphic;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $features_ancient_structures;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $features_paleochannels;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $features_remarks;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $threats_natural_dunes;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $threats_looting;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $threats_cultivation_trenches;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $threats_modern_structures;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $threats_modern_canals;

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
     * @var string
     * @AppAssert\Geom\IsMultipolygon
     * @AppAssert\Geom\IsWgs84
     * @ORM\Column(type="geometry")
     */
    private $geom;

    public function __construct()
    {
        $this->errors = new ArrayCollection();
    }

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
     * @return ArrayCollection
     */
    public function getErrors(): iterable
    {
        return $this->errors;
    }

    /**
     * @param TmpDraftErrorEntity $error
     */
    public function addError(TmpDraftErrorEntity $error): void
    {
        $this->errors[] = $error;
        $error->setDraft($this);
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
    public function getSiteChronology(): ?string
    {
        return $this->site_chronology;
    }

    /**
     * @param string $site_chronology
     *
     * @return TmpDraftEntity
     */
    public function setSiteChronology(string $site_chronology): TmpDraftEntity
    {
        $this->site_chronology = $site_chronology;

        return $this;
    }

    /**
     * @return string
     */
    public function getDistrict(): ?string
    {
        return $this->district;
    }

    /**
     * @param string $district
     *
     * @return TmpDraftEntity
     */
    public function setDistrict(string $district): TmpDraftEntity
    {
        $this->district = $district;

        return $this;
    }

    /**
     * @return string
     */
    public function getFeaturesEpigraphic(): ?string
    {
        return $this->features_epigraphic;
    }

    /**
     * @param string $features_epigraphic
     *
     * @return TmpDraftEntity
     */
    public function setFeaturesEpigraphic(string $features_epigraphic): TmpDraftEntity
    {
        $this->features_epigraphic = $features_epigraphic;

        return $this;
    }

    /**
     * @return string
     */
    public function getFeaturesAncientStructures(): ?string
    {
        return $this->features_ancient_structures;
    }

    /**
     * @param string $features_ancient_structures
     *
     * @return TmpDraftEntity
     */
    public function setFeaturesAncientStructures(string $features_ancient_structures): TmpDraftEntity
    {
        $this->features_ancient_structures = $features_ancient_structures;

        return $this;
    }

    /**
     * @return string
     */
    public function getFeaturesPaleochannels(): ?string
    {
        return $this->features_paleochannels;
    }

    /**
     * @param string $features_paleochannels
     *
     * @return TmpDraftEntity
     */
    public function setFeaturesPaleochannels(string $features_paleochannels): TmpDraftEntity
    {
        $this->features_paleochannels = $features_paleochannels;

        return $this;
    }

    /**
     * @return string
     */
    public function getFeaturesRemarks(): ?string
    {
        return $this->features_remarks;
    }

    /**
     * @param string $features_remarks
     *
     * @return TmpDraftEntity
     */
    public function setFeaturesRemarks(string $features_remarks): TmpDraftEntity
    {
        $this->features_remarks = $features_remarks;

        return $this;
    }

    /**
     * @return string
     */
    public function getThreatsNaturalDunes(): ?string
    {
        return $this->threats_natural_dunes;
    }

    /**
     * @param string $threats_natural_dunes
     */
    public function setThreatsNaturalDunes(string $threats_natural_dunes): void
    {
        $this->threats_natural_dunes = $threats_natural_dunes;
    }

    /**
     * @return string
     */
    public function getThreatsLooting(): ?string
    {
        return $this->threats_looting;
    }

    /**
     * @param string $threats_looting
     */
    public function setThreatsLooting(string $threats_looting): void
    {
        $this->threats_looting = $threats_looting;
    }

    /**
     * @return string
     */
    public function getThreatsCultivationTrenches(): ?string
    {
        return $this->threats_cultivation_trenches;
    }

    /**
     * @param string $threats_cultivation_trenches
     */
    public function setThreatsCultivationTrenches(string $threats_cultivation_trenches): void
    {
        $this->threats_cultivation_trenches = $threats_cultivation_trenches;
    }

    /**
     * @return string
     */
    public function getThreatsModernStructures(): ?string
    {
        return $this->threats_modern_structures;
    }

    /**
     * @param string $threats_modern_structures
     */
    public function setThreatsModernStructures(string $threats_modern_structures): void
    {
        $this->threats_modern_structures = $threats_modern_structures;
    }

    /**
     * @return string
     */
    public function getThreatsModernCanals(): ?string
    {
        return $this->threats_modern_canals;
    }

    /**
     * @param string $threats_modern_canals
     */
    public function setThreatsModernCanals(string $threats_modern_canals): void
    {
        $this->threats_modern_canals = $threats_modern_canals;
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

    /**
     * @return string
     */
    public function getGeom(): ?string
    {
        return $this->geom;
    }

    /**
     * @param string $geom
     *
     * @return TmpDraftEntity
     */
    public function setGeom(string $geom): TmpDraftEntity
    {
        $this->geom = $geom;

        return $this;
    }
}
