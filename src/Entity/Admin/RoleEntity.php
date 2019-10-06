<?php

namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="roles", schema="admin")
 */
class RoleEntity
{

    /**
     * @var string
     * @ORM\Id()
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $name;

    /**
     * @var RoleEntity
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $parent;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="UserRolesEntity", mappedBy="role", cascade={"persist", "remove"})
     */
    private $users;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="GroupRolesEntity", mappedBy="role", cascade={"persist", "remove"})
     */
    private $groups;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->groups = new ArrayCollection();
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
     * @return RoleEntity
     */
    public function getParent(): RoleEntity
    {
        return $this->parent;
    }

    /**
     * @param RoleEntity $parent
     */
    public function setParent(RoleEntity $parent): void
    {
        $this->parent = $parent;
    }

    /**
     * @return ArrayCollection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * GroupEntity $group
     * @param UserEntity $user
     */
    public function addUser(UserEntity $user): void
    {
        $this->users->add($user);
    }

    /**
     * @return ArrayCollection
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    /**
     * GroupEntity $group
     * @param GroupEntity $group
     */
    public function addGroup(GroupEntity $group): void
    {
        $this->groups->add($group);
    }

}
