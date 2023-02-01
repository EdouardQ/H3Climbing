<?php

namespace App\Entity;

use App\Repository\RegistrationRepository;
use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity(repositoryClass: RegistrationRepository::class),
    ORM\Table(name: 'registration'),
]
class Registration
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'registrations')]
    #[ORM\JoinColumn(name: 'user', referencedColumnName: 'id', nullable: false)]
    private ?User $user = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'registrations')]
    #[ORM\JoinColumn(name: 'discovery_day', referencedColumnName: 'id', nullable: false)]
    private ?DiscoveryDay $discoveryDay = null;

    #[ORM\Column(nullable: true)]
    private ?bool $presence = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $requestedAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getDiscoveryDay(): ?DiscoveryDay
    {
        return $this->discoveryDay;
    }

    public function setDiscoveryDay(?DiscoveryDay $discoveryDay): self
    {
        $this->discoveryDay = $discoveryDay;

        return $this;
    }

    public function getPresence(): ?bool
    {
        return $this->presence;
    }

    public function setPresence(?bool $presence): self
    {
        $this->presence = $presence;

        return $this;
    }

    public function getRequestedAt(): ?\DateTimeImmutable
    {
        return $this->requestedAt;
    }

    public function setRequestedAt(\DateTimeImmutable $requestedAt): self
    {
        $this->requestedAt = $requestedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
