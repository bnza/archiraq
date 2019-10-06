<?php

namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="group_roles", schema="admin")
 */
class GroupRolesEntity implements ItemRolesInteface
{

    /**
     * @var GroupEntity
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="GroupEntity", inversedBy="roles")
     * @ORM\JoinColumn(name="groupname", referencedColumnName="name", nullable=false)
     */
    private $group;

    /**
     * @var RoleEntity
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="RoleEntity", inversedBy="groups")
     * @ORM\JoinColumn(name="rolename", referencedColumnName="name", nullable=false)
     */
    private $role;

    /**
     * @return GroupEntity
     */
    public function getGroup(): GroupEntity
    {
        return $this->group;
    }

    /**
     * @param GroupEntity $group
     */
    public function setGroup(GroupEntity $group): void
    {
        $this->group = $group;
    }

    /**
     * @return RoleEntity
     */
    public function getRole(): RoleEntity
    {
        return $this->role;
    }

    /**
     * @param RoleEntity $role
     */
    public function setRole(RoleEntity $role): void
    {
        $this->role = $role;
    }

}
