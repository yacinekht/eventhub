<?php

namespace App\Entity;

use App\Enum\EventStatus;
use App\Enum\RegistrationStatus;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RegistrationRepository::class)]
#[ORM\Table(
    name: 'registration',
    uniqueConstraints: [
        new ORM\UniqueConstraint(
            name: 'user_event_unique',
            columns: ['user_id', 'event_id']
        )
    ]
)]
class Registration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column(enumType:RegistrationStatus::class)]
    private RegistrationStatus $status;


    #[ORM\ManyToOne(inversedBy: 'registrations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'registrations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct(RegistrationStatus $status){
        $this->status=$status;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus(RegistrationStatus $status)
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

return $this;
}

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): self
    {
        $this->event = $event;

return $this;
}
}
