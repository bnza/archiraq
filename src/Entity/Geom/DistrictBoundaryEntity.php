<?php

namespace App\Entity\Geom;

use App\Entity\EntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Geom\DistrictBoundaryRepository")
 * @ORM\Table(name="admbnd2", schema="geom")
 */
class DistrictBoundaryEntity implements EntityInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="geom.seq__admbnd2__id")
     *
     * @var int
     */
    private $id;

    /**
     * @var NationBoundaryEntity
     * @ORM\ManyToOne(targetEntity="GovernorateBoundaryEntity", inversedBy="districts")
     * @ORM\JoinColumn(name="admbnd1_id", referencedColumnName="id", nullable=false, onDelete="NO ACTION")
     */
    private $governorate;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\SiteEntity", mappedBy="district")
     */
    private $sites;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(name="altname", type="string", nullable=false)
     *
     * @var string
     */
    private $alternative_name;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="geometry", nullable=false)
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
     *
     * @return DistrictBoundaryEntity
     */
    public function setId(int $id): DistrictBoundaryEntity
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return DistrictBoundaryEntity
     */
    public function setName(string $name): DistrictBoundaryEntity
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getAlternativeName(): string
    {
        return $this->alternative_name;
    }

    /**
     * @param string $alternative_name
     *
     * @return DistrictBoundaryEntity
     */
    public function setAlternativeName(string $alternative_name): DistrictBoundaryEntity
    {
        $this->alternative_name = $alternative_name;

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
     *
     * @return DistrictBoundaryEntity
     */
    public function setGeom(string $geom): DistrictBoundaryEntity
    {
        $this->geom = $geom;

        return $this;
    }

    /**
     * @return NationBoundaryEntity
     */
    public function getGovernorate(): NationBoundaryEntity
    {
        return $this->governorate;
    }

    /**
     * @param NationBoundaryEntity $governorate
     *
     * @return DistrictBoundaryEntity
     */
    public function setGovernorate(NationBoundaryEntity $governorate): DistrictBoundaryEntity
    {
        $this->governorate = $governorate;

        return $this;
    }
}
