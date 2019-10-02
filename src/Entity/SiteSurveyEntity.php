<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="site_survey", schema="public")
 */
class SiteSurveyEntity implements EntityInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="public.seq___site_survey__id")
     *
     * @var int
     */
    private $id;

    /**
     * @var SiteEntity
     * @ORM\ManyToOne(targetEntity="SiteEntity", inversedBy="surveys")
     * @ORM\JoinColumn(name="site_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $site;

    /**
     * @var Voc\SurveyEntity;
     * @ORM\ManyToOne(targetEntity="\App\Entity\Voc\SurveyEntity", inversedBy="sites")
     * @ORM\JoinColumn(name="survey_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $survey;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $ref;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    private $year_low;

    /**
     * @var int
     * @ORM\Column(type="smallint")
     */
    private $year_high;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $remarks;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return SiteSurveyEntity
     */
    public function setId(int $id): SiteSurveyEntity
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return SiteEntity
     */
    public function getSite(): SiteEntity
    {
        return $this->site;
    }

    /**
     * @param SiteEntity $site
     * @return SiteSurveyEntity
     */
    public function setSite(SiteEntity $site): SiteSurveyEntity
    {
        $this->site = $site;
        return $this;
    }

    /**
     * @return Voc\SurveyEntity
     */
    public function getSurvey(): Voc\SurveyEntity
    {
        return $this->survey;
    }

    /**
     * @param Voc\SurveyEntity $survey
     * @return SiteSurveyEntity
     */
    public function setSurvey(Voc\SurveyEntity $survey): SiteSurveyEntity
    {
        $this->survey = $survey;
        return $this;
    }

    /**
     * @return string
     */
    public function getRef(): ?string
    {
        return $this->ref;
    }

    /**
     * @param string $ref
     */
    public function setRef(string $ref): void
    {
        $this->ref = $ref;
    }

    /**
     * @return int
     */
    public function getYearLow(): ?int
    {
        return $this->year_low;
    }

    /**
     * @param int $year_low
     */
    public function setYearLow(?int $year_low): void
    {
        $this->year_low = $year_low;
    }

    /**
     * @return int
     */
    public function getYearHigh(): ?int
    {
        return $this->year_high;
    }

    /**
     * @param int $year_high
     */
    public function setYearHigh(?int $year_high): void
    {
        $this->year_high = $year_high;
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
    public function setRemarks(?string $remarks): void
    {
        $this->remarks = $remarks;
    }
}
