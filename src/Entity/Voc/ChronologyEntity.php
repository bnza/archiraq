<?php

namespace App\Entity\Voc;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\EntityInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Voc\ChronologyRepository")
 * @ORM\Table(name="chronology", schema="voc")
 * @UniqueEntity(
 *      fields={"code"},
 *      message="Duplicate chronology code {{ value }}",
 * )
 * @UniqueEntity(
 *      fields={"name"},
 *      message="Duplicate chronology name {{ value }}",
 * )
 */
class ChronologyEntity implements EntityInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="voc.seq___chronology__id")
     *
     * @var int
     */
    private $id;

    /**
     * @var ArrayCollection;
     * @ORM\OneToMany(targetEntity="\App\Entity\SiteChronologyEntity", mappedBy="chronology")
     */
    private $sites;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $code;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $date_low;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $date_high;

    public function __construct()
    {
        $this->sites = new ArrayCollection();
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
     * @return ChronologyEntity
     */
    public function setId(int $id): ChronologyEntity
    {
        $this->id = $id;

        return $this;
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
     * @return ChronologyEntity
     */
    public function setCode(string $code): ChronologyEntity
    {
        $this->code = $code;

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
     * @return ChronologyEntity
     */
    public function setName(string $name): ChronologyEntity
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int
     */
    public function getDateLow(): ?int
    {
        return $this->date_low;
    }

    /**
     * @param int $date_low
     *
     * @return ChronologyEntity
     */
    public function setDateLow(int $date_low): ChronologyEntity
    {
        $this->date_low = $date_low;

        return $this;
    }

    /**
     * @return int
     */
    public function getDateHigh(): ?int
    {
        return $this->date_high;
    }

    /**
     * @param int $date_high
     *
     * @return ChronologyEntity
     */
    public function setDateHigh(int $date_high): ChronologyEntity
    {
        $this->date_high = $date_high;

        return $this;
    }
}
