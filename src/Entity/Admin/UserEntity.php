<?php

namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Admin\UserRepository")
 * @ORM\Table(name="users", schema="admin")
 */
class UserEntity implements UserInterface
{

    /**
     * @ORM\Id()
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $name;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="UserRolesEntity", mappedBy="user", cascade={"persist", "remove"})
     */
    private $dbRoles;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="GroupMembersEntity", mappedBy="user", cascade={"persist", "remove"})
     */
    private $groups;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    public function __construct()
    {
        $this->dbRoles = new ArrayCollection();
    }


    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->name;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $userRoles = array_map([$this, 'extractRoleName'], $this->dbRoles->getValues());
        $groupRoles = $this->extractUserGroupRoles();
        $roles = array_merge($userRoles, $groupRoles);
        return array_unique($roles);
    }

    /**
     * @return ArrayCollection
     */
    public function getDbRoles(): Collection
    {
        return $this->dbRoles;
    }

    /**
     * @param ArrayCollection $dbRoles
     */
    public function setDbRoles(ArrayCollection $dbRoles): void
    {
        $this->dbRoles = $dbRoles;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    /**
     * @param GroupEntity $group
     */
    public function addGroups(GroupEntity $group): void
    {
        $this->groups->add($group);
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    private function extractRoleName(ItemRolesInteface $itemRoles): string
    {
        return $itemRoles->getRole()->getName();
    }

    private function extractUserGroupRoles(): iterable
    {
        $roles = [];
        foreach ($this->getGroups() as $groupMember) {
            foreach ($groupMember->getGroup()->getRoles() as $roleMember) {
                $roles[] = $this->extractRoleName($roleMember);
            }
        }


        return $roles;
    }
}
