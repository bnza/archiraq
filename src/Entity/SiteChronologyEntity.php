<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SiteChronologyRepository")
 * @ORM\Table(name="site_chronology", schema="public")
 * @UniqueEntity(
 *      fields={"site", "chronology"},
 *      message="Duplicate chronology code {{ value }}",
 * )
 */
class SiteChronologyEntity implements EntityInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="public.seq___site_chronology__id")
     *
     * @var int
     */
    private $id;

    /**
     * @var SiteEntity
     * @ORM\ManyToOne(targetEntity="SiteEntity", inversedBy="chronologies")
     * @ORM\JoinColumn(name="site_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $site;

    /**
     * @var Voc\ChronologyEntity
     * @ORM\ManyToOne(targetEntity="\App\Entity\Voc\ChronologyEntity", inversedBy="sites")
     * @ORM\JoinColumn(name="chronology_id", referencedColumnName="id", nullable=false, onDelete="NO ACTION")
     */
    private $chronology;

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
     * @return SiteChronologyEntity
     */
    public function setId(int $id): SiteChronologyEntity
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
     *
     * @return SiteChronologyEntity
     */
    public function setSite(SiteEntity $site): SiteChronologyEntity
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return Voc\ChronologyEntity
     */
    public function getChronology(): Voc\ChronologyEntity
    {
        return $this->chronology;
    }

    /**
     * @param Voc\ChronologyEntity $chronology
     *
     * @return SiteChronologyEntity
     */
    public function setChronology(Voc\ChronologyEntity $chronology): SiteChronologyEntity
    {
        $this->chronology = $chronology;

        return $this;
    }
}
