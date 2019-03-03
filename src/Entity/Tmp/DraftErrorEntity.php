<?php

namespace App\Entity\Tmp;

use App\Entity\EntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\Tmp\DraftErrorRepository")
 * @ORM\Table(name="draft_error", schema="tmp")
 */
class DraftErrorEntity implements EntityInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="tmp.seq___draft_error__id")
     *
     * @var int
     */
    private $id;

    /**
     * @var DraftEntity
     * @ORM\ManyToOne(targetEntity="DraftEntity", inversedBy="errors")
     * @ORM\JoinColumn(name="draft_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $draft;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="text", nullable=false)
     */
    private $message;

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
     * @return DraftErrorEntity
     */
    public function setId(int $id): DraftErrorEntity
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return DraftEntity
     */
    public function getDraft(): DraftEntity
    {
        return $this->draft;
    }

    /**
     * @param DraftEntity $draft
     *
     * @return DraftErrorEntity
     */
    public function setDraft(DraftEntity $draft): DraftErrorEntity
    {
        $this->draft = $draft;

        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     *
     * @return DraftErrorEntity
     */
    public function setPath(string $path): DraftErrorEntity
    {
        $this->path = $path;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return DraftErrorEntity
     */
    public function setMessage(string $message): DraftErrorEntity
    {
        $this->message = $message;

        return $this;
    }
}
