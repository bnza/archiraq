<?php

namespace App\Entity;

use App\Entity\Tmp\DraftEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ContributeRepository")
 * @ORM\Table(name="contribute", schema="public")
 */
class ContributeEntity implements EntityInterface
{
    const STATUS_VALIDATE = 0b0001;
    const STATUS_VALID = 0b0010;
    const STATUS_ACCEPTED = 0b0100;
    const STATUS_REJECTED = 0b1000;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="public.seq___contribute__id")
     *
     * @var int
     */
    private $id;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="SiteEntity", mappedBy="contribute")
     */
    private $sites;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Tmp\DraftEntity", mappedBy="contribute")
     */
    private $drafts;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(min=40,max=40)
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $sha1;

    /**
     * @Assert\NotBlank()
     * @Assert\Email()
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $contributor;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $institution;

    /**
     * @ORM\Column(type="string", nullable=true)
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="smallint", nullable=false)
     */
    private $status = 0;

    public function __construct()
    {
        $this->sites = new ArrayCollection();
        $this->drafts = new ArrayCollection();
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
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getContributor(): ?string
    {
        return $this->contributor;
    }

    /**
     * @param string $contributor
     */
    public function setContributor(string $contributor): void
    {
        $this->contributor = $contributor;
    }

    /**
     * @return string
     */
    public function getInstitution(): ?string
    {
        return $this->institution;
    }

    /**
     * @param string $institution
     */
    public function setInstitution(string $institution): void
    {
        $this->institution = $institution;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getSha1(): string
    {
        return $this->sha1;
    }

    /**
     * @param string $sha1
     */
    public function setSha1(string $sha1): void
    {
        $this->sha1 = $sha1;
    }

    /**
     * @return ArrayCollection
     */
    public function getSites(): iterable
    {
        return $this->sites;
    }

    /**
     * @param SiteEntity $site
     */
    public function addSite(SiteEntity $site): void
    {
        $this->sites[] = $site;
        $site->setContribute($this);
    }

    /**
     * @return ArrayCollection
     */
    public function getDrafts(): iterable
    {
        return $this->drafts;
    }

    /**
     * @param DraftEntity $draft
     */
    public function addDraft(DraftEntity $draft): void
    {
        $this->drafts[] = $draft;
        $draft->setContribute($this);
    }

    public function isValidate(): bool
    {
        return (bool) ($this->status & self::STATUS_VALIDATE);
    }

    public function isValid(): bool
    {
        return $this->isValidate() && ($this->status & self::STATUS_VALID);
    }

    public function isPending(): bool
    {
        return (bool) !($this->status & (self::STATUS_ACCEPTED | self::STATUS_REJECTED));
    }
}
