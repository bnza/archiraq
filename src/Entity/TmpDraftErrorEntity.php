<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 13/02/19
 * Time: 10.13.
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TmpDraftErrorRepository")
 * @ORM\Table(name="draft_error", schema="tmp")
 */
class TmpDraftErrorEntity implements EntityInterface
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
     * @var TmpDraftEntity
     * @ORM\ManyToOne(targetEntity="TmpDraftEntity", inversedBy="errors")
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
     * @return TmpDraftErrorEntity
     */
    public function setId(int $id): TmpDraftErrorEntity
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return TmpDraftEntity
     */
    public function getDraft(): TmpDraftEntity
    {
        return $this->draft;
    }

    /**
     * @param TmpDraftEntity $draft
     *
     * @return TmpDraftErrorEntity
     */
    public function setDraft(TmpDraftEntity $draft): TmpDraftErrorEntity
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
     * @return TmpDraftErrorEntity
     */
    public function setPath(string $path): TmpDraftErrorEntity
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
     * @return TmpDraftErrorEntity
     */
    public function setMessage(string $message): TmpDraftErrorEntity
    {
        $this->message = $message;

        return $this;
    }
}
