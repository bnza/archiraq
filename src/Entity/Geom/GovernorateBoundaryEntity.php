<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 13/02/19
 * Time: 17.01.
 */

namespace App\Entity\Geom;

use App\Entity\EntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="admbnd1", schema="geom")
 */
class GovernorateBoundaryEntity implements EntityInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="geom.seq__admbnd1__id")
     *
     * @var int
     */
    private $id;

    /**
     * @var NationBoundaryEntity
     * @ORM\ManyToOne(targetEntity="NationBoundaryEntity", inversedBy="governorates")
     * @ORM\JoinColumn(name="admbnd0_code", referencedColumnName="code", nullable=false, onDelete="NO ACTION")
     */
    private $nation;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="DistrictBoundaryEntity", mappedBy="governorate")
     */
    private $districts;

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
     * @return GovernorateBoundaryEntity
     */
    public function setId(int $id): GovernorateBoundaryEntity
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return NationBoundaryEntity
     */
    public function getNation(): NationBoundaryEntity
    {
        return $this->nation;
    }

    /**
     * @param NationBoundaryEntity $nation
     *
     * @return GovernorateBoundaryEntity
     */
    public function setNation(NationBoundaryEntity $nation): GovernorateBoundaryEntity
    {
        $this->nation = $nation;

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
     * @return GovernorateBoundaryEntity
     */
    public function setName(string $name): GovernorateBoundaryEntity
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
     * @return GovernorateBoundaryEntity
     */
    public function setAlternativeName(string $alternative_name): GovernorateBoundaryEntity
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
     * @return GovernorateBoundaryEntity
     */
    public function setGeom(string $geom): GovernorateBoundaryEntity
    {
        $this->geom = $geom;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getDistricts(): iterable
    {
        return $this->districts;
    }

    /**
     * @param DistrictBoundaryEntity $district
     *
     * @return GovernorateBoundaryEntity
     */
    public function addDistrict(DistrictBoundaryEntity $district): GovernorateBoundaryEntity
    {
        $this->districts[] = $district;

        return $this;
    }
}
