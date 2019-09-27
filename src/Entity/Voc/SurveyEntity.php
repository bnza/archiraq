<?php

namespace App\Entity\Voc;

use App\Entity\EntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Voc\SurveyRepository")
 * @ORM\Table(name="survey", schema="voc")
 */
class SurveyEntity implements EntityInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="voc.seq___survey__id")
     *
     * @var int
     */
    private $id;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="\App\Entity\SiteSurveyEntity", mappedBy="survey", cascade={"persist", "remove"})
     */
    private $sites;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $code;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $name;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="text", nullable=true)
     *
     * @var string
     */
    private $remarks;

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
     * @return SurveyEntity
     */
    public function setId(int $id): SurveyEntity
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
     * @return SurveyEntity
     */
    public function setCode(string $code): SurveyEntity
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return SurveyEntity
     */
    public function setName(?string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    /**
     * @param mixed $remarks
     * @return SurveyEntity
     */
    public function setRemarks(?string $remarks)
    {
        $this->remarks = $remarks;
        return $this;
    }

}
