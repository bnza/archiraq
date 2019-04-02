<?php

namespace App\Entity\Admin;

use Doctrine\Common\Collections\ArrayCollection;
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
    private $roles;

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
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
        return array_map([$this, 'extractUserRole'], $this->roles->getValues());
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

    private function extractUserRole(UserRolesEntity $userRoles)
    {
        return $userRoles->getRole()->getName();
    }
}
