<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
#[Entity(repositoryClass: UserRepository::class)]
#[Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[Id, Column(type: 'integer'), GeneratedValue]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'organizer', targetEntity: Event::class)]
    private Collection $events;
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Registration::class)]
    private Collection $registrations;
    #[Column(type: 'string', length: 100, nullable: false)]
    #[Assert\NotBlank, Assert\Type('string')]
    private string $username;

    #[Column(type: 'string', length: 180, unique: true)]
    #[Assert\Email]
    private string $email;

    #[Column(type: 'string', nullable: false)]
    #[Assert\NotBlank]
    private string $password;

    #[Column(type: 'json')]
    #[Assert\NotBlank]
    private array $roles = ['ROLE_USER'];

    #[Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
    private \DateTimeImmutable $createdAt;


    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->events = new ArrayCollection();
        $this->registrations = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = strtolower(trim($email)); // pour mettre tout en minuscule
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return array_unique([...$this->roles]);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
 ///////////////////////////////////////////////////////////////////////////////////
    public function eraseCredentials(): void
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        return $this->getUsername();
    }

    public function getEvents(): Collection
    {
        return $this->events;
    }
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }
}
