<?php


namespace App\Entity\Admin;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_roles", schema="admin")
 */
class UserRolesEntity implements ItemRolesInteface
{
    /**
     * @var UserEntity
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="UserEntity", inversedBy="dbRoles")
     * @ORM\JoinColumn(name="username", referencedColumnName="name", nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @var RoleEntity
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="RoleEntity", inversedBy="users")
     * @ORM\JoinColumn(name="rolename", referencedColumnName="name", nullable=false, onDelete="CASCADE")
     */
    private $role;

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
