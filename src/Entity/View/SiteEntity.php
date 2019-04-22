<?php

namespace App\Entity\View;
use App\Entity\EntityInterface;
use App\Entity\SiteEntity as BaseSiteEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\View\SiteRepository")
 * @ORM\Table(name="vw_site_poly", schema="geom")
 */
class SiteEntity implements EntityInterface
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="App\Entity\SiteEntity")
     * @ORM\JoinColumn(name="id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var BaseSiteEntity
     */
    private $site;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $sbah_no;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $modern_name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nearest_city;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $ancient_name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $district;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $governorate;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nation;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $chronology;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $surveyRefs;

    /**
     * @var float
     * @ORM\Column(type="string")
     */
    private $area;

    /**
     * @ORM\Column(type="geometry")
     *
     * @var string
     */
    private $geom;

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
     * @return BaseSiteEntity
     */
    public function getSite(): BaseSiteEntity
    {
        return $this->site;
    }

    /**
     * @param BaseSiteEntity $site
     * @return SiteEntity
     */
    public function setSite(BaseSiteEntity $site): SiteEntity
    {
        $this->site = $site;
        return $this;
    }

    /**
     * @return string
     */
    public function getSbahNo(): string
    {
        return $this->sbah_no;
    }

    /**
     * @param string $sbah_no
     * @return SiteEntity
     */
    public function setSbahNo(string $sbah_no): SiteEntity
    {
        $this->sbah_no = $sbah_no;
        return $this;
    }

    /**
     * @return string
     */
    public function getModernName(): string
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
    public function getNearestCity(): string
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
    public function getAncientName(): string
    {
        return $this->ancient_name;
    }

    /**
     * @param string $ancient_name
     * @return SiteEntity
     */
    public function setAncientName(string $ancient_name): SiteEntity
    {
        $this->ancient_name = $ancient_name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDistrict(): string
    {
        return $this->district;
    }

    /**
     * @param string $district
     * @return SiteEntity
     */
    public function setDistrict(string $district): SiteEntity
    {
        $this->district = $district;
        return $this;
    }

    /**
     * @return string
     */
    public function getGovernorate(): string
    {
        return $this->governorate;
    }

    /**
     * @param string $governorate
     * @return SiteEntity
     */
    public function setGovernorate(string $governorate): SiteEntity
    {
        $this->governorate = $governorate;
        return $this;
    }

    /**
     * @return string
     */
    public function getNation(): string
    {
        return $this->nation;
    }

    /**
     * @param string $nation
     * @return SiteEntity
     */
    public function setNation(string $nation): SiteEntity
    {
        $this->nation = $nation;
        return $this;
    }

    /**
     * @return string
     */
    public function getChronology(): string
    {
        return $this->chronology;
    }

    /**
     * @param string $chronology
     * @return SiteEntity
     */
    public function setChronology(string $chronology): SiteEntity
    {
        $this->chronology = $chronology;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurveyRefs(): string
    {
        return $this->surveyRefs;
    }

    /**
     * @param string $surveyRefs
     * @return SiteEntity
     */
    public function setSurveyRefs(string $surveyRefs): SiteEntity
    {
        $this->surveyRefs = $surveyRefs;
        return $this;
    }

    /**
     * @return float
     */
    public function getArea(): float
    {
        return $this->area;
    }

    /**
     * @param float $area
     * @return SiteEntity
     */
    public function setArea(float $area): SiteEntity
    {
        $this->area = $area;
        return $this;
    }

    /**
     * @return string
     */
    public function getGeom(): string
    {
        return $this->geom;
    }

    /**
     * @param string $geom
     * @return SiteEntity
     */
    public function setGeom(string $geom): SiteEntity
    {
        $this->geom = $geom;
        return $this;
    }

}
