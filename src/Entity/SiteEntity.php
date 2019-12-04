<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SiteRepository")
 * @ORM\Table(name="site", schema="public")
 * @UniqueEntity(
 *      fields={"contribute", "entry_id"},
 *      message="Duplicate entry id {{ value }} for this contribute"
 * )
 * @UniqueEntity(
 *      fields={"sbah_no"},
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
     *
     * @var int
     */
    private $id;

    /**
     * @Assert\NotBlank
     * @var ContributeEntity
     * @ORM\ManyToOne(targetEntity="ContributeEntity", inversedBy="sites")
     * @ORM\JoinColumn(name="contribute_id", referencedColumnName="id", nullable=false, onDelete="NO ACTION")
     */
    private $contribute;

    /**
     * @Assert\NotBlank
     * @var Geom\DistrictBoundaryEntity
     * @ORM\ManyToOne(targetEntity="App\Entity\Geom\DistrictBoundaryEntity", inversedBy="sites")
     * @ORM\JoinColumn(name="district_id", referencedColumnName="id", nullable=false, onDelete="NO ACTION")
     */
    private $district;

    /**
     * @var Geom\SiteBoundaryEntity
     * @ORM\OneToOne(targetEntity="App\Entity\Geom\SiteBoundaryEntity", mappedBy="site", cascade={"persist", "remove"})
     */
    private $geom;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SiteChronologyEntity", mappedBy="site", cascade={"persist", "remove"})
     */
    private $chronologies;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SiteSurveyEntity", mappedBy="site", cascade={"persist", "remove"})
     */
    private $surveys;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $entry_id;

    /**
     * @Assert\NotNull
     * @var bool
     * @ORM\Column(type="boolean", nullable=false)
     */
    private $remote_sensing;

    /**
     * @var bool
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $survey_verified_on_field;

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
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $features_epigraphic;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $features_ancient_structures;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $features_paleochannels;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $features_remarks;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $threats_natural_dunes;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $threats_looting;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $threats_cultivation_trenches;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $threats_modern_structures;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $threats_modern_canals;

    /**
     * @var bool
     * @ORM\Column(type="boolean")
     */
    private $threats_bulldozer;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $excavations_whom_when;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $excavations_bibliography;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $compiler;

    /**
     * @var \DateTime
     * @Assert\NotBlank()
     * @ORM\Column(type="date", nullable=false)
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

    public function __construct()
    {
        $this->chronologies = new ArrayCollection();
        $this->surveys = new ArrayCollection();
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
     *
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
     *
     * @return SiteEntity
     */
    public function setContribute(ContributeEntity $contribute): SiteEntity
    {
        $this->contribute = $contribute;

        return $this;
    }

    /**
     * @return bool
     */
    public function isRemoteSensing(): bool
    {
        return $this->remote_sensing;
    }

    /**
     * @param bool $remote_sensing
     * @return SiteEntity
     */
    public function setRemoteSensing(bool $remote_sensing): SiteEntity
    {
        $this->remote_sensing = $remote_sensing;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSurveyVerifiedOnField(): ?bool
    {
        return $this->survey_verified_on_field;
    }

    /**
     * @param bool $verified
     * @return SiteEntity
     */
    public function setSurveyVerifiedOnField(?bool $verified): SiteEntity
    {
        $this->survey_verified_on_field = $verified;
        return $this;
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
     *
     * @return SiteEntity
     */
    public function setEntryId(?string $entry_id): SiteEntity
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
     *
     * @return SiteEntity
     */
    public function setNearestCity(?string $nearest_city): SiteEntity
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
     *
     * @return SiteEntity
     */
    public function setModernName(?string $modern_name): SiteEntity
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
     *
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
     *
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
     *
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
     *
     * @return SiteEntity
     */
    public function setCadastre(?string $cadastre): SiteEntity
    {
        $this->cadastre = $cadastre;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getChronologies(): Collection
    {
        return $this->chronologies;
    }

    /**
     * @param SiteChronologyEntity $chronology
     */
    public function addChronology(SiteChronologyEntity $chronology): void
    {
        $this->chronologies[] = $chronology;
        $chronology->setSite($this);
    }

    /**
     * @return ArrayCollection
     */
    public function getSurveys(): Collection
    {
        return $this->surveys;
    }

    /**
     * @param SiteSurveyEntity $survey
     */
    public function addSurvey(SiteSurveyEntity $survey): void
    {
        $this->surveys[] = $survey;
        $survey->setSite($this);
    }

    /**
     * @return bool
     */
    public function hasFeaturesEpigraphic(): ?bool
    {
        return $this->features_epigraphic;
    }

    /**
     * @param bool $features_epigraphic
     */
    public function setFeaturesEpigraphic(?bool $features_epigraphic): void
    {
        $this->features_epigraphic = $features_epigraphic;
    }

    /**
     * @return bool
     */
    public function hasFeaturesAncientStructures(): ?bool
    {
        return $this->features_ancient_structures;
    }

    /**
     * @param bool $features_ancient_structures
     */
    public function setFeaturesAncientStructures(?bool $features_ancient_structures): void
    {
        $this->features_ancient_structures = $features_ancient_structures;
    }

    /**
     * @return bool
     */
    public function hasFeaturesPaleochannels(): ?bool
    {
        return $this->features_paleochannels;
    }

    /**
     * @param bool $features_paleochannels
     */
    public function setFeaturesPaleochannels(?bool $features_paleochannels): void
    {
        $this->features_paleochannels = $features_paleochannels;
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
     */
    public function setFeaturesRemarks(?string $features_remarks): void
    {
        $this->features_remarks = $features_remarks;
    }

    /**
     * @return bool
     */
    public function hasThreatsNaturalDunes(): ?bool
    {
        return $this->threats_natural_dunes;
    }

    /**
     * @param bool $threats_natural_dunes
     *
     * @return SiteEntity
     */
    public function setThreatsNaturalDunes(?bool $threats_natural_dunes): SiteEntity
    {
        $this->threats_natural_dunes = $threats_natural_dunes;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasThreatsLooting(): ?bool
    {
        return $this->threats_looting;
    }

    /**
     * @param bool $threats_looting
     *
     * @return SiteEntity
     */
    public function setThreatsLooting(?bool $threats_looting): SiteEntity
    {
        $this->threats_looting = $threats_looting;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasThreatsCultivationTrenches(): ?bool
    {
        return $this->threats_cultivation_trenches;
    }

    /**
     * @param bool $threats_cultivation_trenches
     *
     * @return SiteEntity
     */
    public function setThreatsCultivationTrenches(?bool $threats_cultivation_trenches): SiteEntity
    {
        $this->threats_cultivation_trenches = $threats_cultivation_trenches;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasThreatsModernStructures(): ?bool
    {
        return $this->threats_modern_structures;
    }

    /**
     * @param bool $threats_modern_structures
     *
     * @return SiteEntity
     */
    public function setThreatsModernStructures(?bool $threats_modern_structures): SiteEntity
    {
        $this->threats_modern_structures = $threats_modern_structures;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasThreatsModernCanals(): ?bool
    {
        return $this->threats_modern_canals;
    }

    /**
     * @param bool $threats_modern_canals
     *
     * @return SiteEntity
     */
    public function setThreatsModernCanals(?bool $threats_modern_canals): SiteEntity
    {
        $this->threats_modern_canals = $threats_modern_canals;

        return $this;
    }

    /**
     * @return bool
     */
    public function hasThreatsBulldozer(): ?bool
    {
        return $this->threats_bulldozer;
    }

    /**
     * @param bool $threats_bulldozer
     * @return SiteEntity
     */
    public function setThreatsBulldozer(?bool $threats_bulldozer): SiteEntity
    {
        $this->threats_bulldozer = $threats_bulldozer;
        return $this;
    }

    /**
     * @return string
     */
    public function getExcavationsWhomWhen(): ?string
    {
        return $this->excavations_whom_when;
    }

    /**
     * @param string $excavations_whom_when
     */
    public function setExcavationsWhomWhen(string $excavations_whom_when): void
    {
        $this->excavations_whom_when = $excavations_whom_when;
    }

    /**
     * @return string
     */
    public function getExcavationsBibliography(): ?string
    {
        return $this->excavations_bibliography;
    }

    /**
     * @param string $excavations_bibliography
     */
    public function setExcavationsBibliography(string $excavations_bibliography): void
    {
        $this->excavations_bibliography = $excavations_bibliography;
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
     *
     * @return SiteEntity
     */
    public function setCompiler(?string $compiler): SiteEntity
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
     *
     * @return SiteEntity
     */
    public function setCompilationDate(?\DateTime $compilation_date): SiteEntity
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
     *
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
     *
     * @return SiteEntity
     */
    public function setCredits(?string $credits): SiteEntity
    {
        $this->credits = $credits;

        return $this;
    }

    /**
     * @return Geom\DistrictBoundaryEntity
     */
    public function getDistrict(): Geom\DistrictBoundaryEntity
    {
        return $this->district;
    }

    /**
     * @param Geom\DistrictBoundaryEntity $district
     *
     * @return SiteEntity
     */
    public function setDistrict(?Geom\DistrictBoundaryEntity $district): SiteEntity
    {
        $this->district = $district;

        return $this;
    }

    /**
     * @return Geom\SiteBoundaryEntity
     */
    public function getGeom(): Geom\SiteBoundaryEntity
    {
        return $this->geom;
    }

    /**
     * @param Geom\SiteBoundaryEntity $geom
     *
     * @return SiteEntity
     */
    public function setGeom(Geom\SiteBoundaryEntity $geom): SiteEntity
    {
        $this->geom = $geom;
        $geom->setSite($this);

        return $this;
    }
}
