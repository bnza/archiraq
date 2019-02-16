<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 13/02/19
 * Time: 17.01.
 */

namespace App\Entity\Geom;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="admbnd0", schema="geom")
 */
class NationBoundaryEntity
{
    /**
     * @ORM\Id
     * @Assert\NotBlank()
     * @Assert\Length(min=2,max=2)
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $code;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="GovernorateBoundaryEntity", mappedBy="nation")
     */
    private $governorates;

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
     * @ORM\Column(type="multipolygon", nullable=false)
     *
     * @var string
     */
    private $geom;

    public function __construct()
    {
        $this->governorates = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     *
     * @return NationBoundaryEntity
     */
    public function setCode(string $code): NationBoundaryEntity
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getGovernorates(): iterable
    {
        return $this->governorates;
    }

    /**
     * @param GovernorateBoundaryEntity $governorate
     *
     * @return NationBoundaryEntity
     */
    public function addGovernorate(GovernorateBoundaryEntity $governorate): NationBoundaryEntity
    {
        $this->governorates[] = $governorate;

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
     * @return NationBoundaryEntity
     */
    public function setName(string $name): NationBoundaryEntity
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
     * @return NationBoundaryEntity
     */
    public function setAlternativeName(string $alternative_name): NationBoundaryEntity
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
     * @return NationBoundaryEntity
     */
    public function setGeom(string $geom): NationBoundaryEntity
    {
        $this->geom = $geom;

        return $this;
    }
}
