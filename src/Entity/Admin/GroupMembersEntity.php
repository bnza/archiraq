<?php

namespace App\Entity\Admin;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="group_members", schema="admin")
 */
class GroupMembersEntity
{

    /**
     * @var GroupEntity
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="GroupEntity")
     * @ORM\JoinColumn(name="groupname", referencedColumnName="name", nullable=false)
     */
    private $group;

    /**
     * @var UserEntity
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="UserEntity", inversedBy="groups")
     * @ORM\JoinColumn(name="username", referencedColumnName="name", nullable=false)
     */
    private $user;

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
     * @return UserEntity
     */
    public function getUser(): UserEntity
    {
        return $this->user;
    }

    /**
     * @param UserEntity $user
     */
    public function setUser(UserEntity $user): void
    {
        $this->user = $user;
    }


}
