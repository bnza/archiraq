<?php

namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="groups", schema="admin")
 *
 */
class GroupEntity
{

    /**
     * @var string
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="GroupRolesEntity")
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $name;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    private $enabled;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="GroupRolesEntity", mappedBy="group", cascade={"persist", "remove"})
     */
    private $roles;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
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
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @return ArrayCollection
     */
    public function getRoles(): Collection
    {
        return $this->roles;
    }

    /**
     * @param RoleEntity $role
     */
    public function addRole(RoleEntity $role): void
    {
        $this->roles->add($role);
    }
}
