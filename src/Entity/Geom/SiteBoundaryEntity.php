<?php
/**
 * Created by PhpStorm.
 * User: petrux
 * Date: 14/02/19
 * Time: 13.03.
 */

namespace App\Entity\Geom;

use App\Entity\SiteEntity;
use App\Entity\EntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="site", schema="geom")
 */
class SiteBoundaryEntity implements EntityInterface
{
    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="App\Entity\SiteEntity", inversedBy="geom")
     * @ORM\JoinColumn(name="id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     *
     * @var SiteEntity
     */
    private $site;

    /**
     * @Assert\NotBlank()
     * @ORM\Column(type="geometry", nullable=false)
     *
     * @var string
     */
    private $geom;

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
     * @return SiteBoundaryEntity
     */
    public function setSite(SiteEntity $site): SiteBoundaryEntity
    {
        $this->site = $site;

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
     * @return SiteBoundaryEntity
     */
    public function setGeom(string $geom): SiteBoundaryEntity
    {
        $this->geom = $geom;

        return $this;
    }

    public function getId(): int
    {
        return $this->site ? $this->site->getId() : null;
    }
}
