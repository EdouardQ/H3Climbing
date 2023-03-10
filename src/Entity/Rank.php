<?php

namespace App\Entity;

use App\Repository\RankRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[
    ORM\Entity(repositoryClass: RankRepository::class),
    ORM\Table(name: 'rank')
]
class Rank
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'rank', targetEntity: User::class)]
    private Collection $users;

    #[ORM\Column]
    private ?int $requirement = null;

    #[ORM\OneToMany(mappedBy: 'minimumRank', targetEntity: DiscoveryDay::class)]
    private Collection $discoveryDays;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->discoveryDays = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setRank($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getRank() === $this) {
                $user->setRank(null);
            }
        }

        return $this;
    }

    public function getRequirement(): ?int
    {
        return $this->requirement;
    }

    public function setRequirement(int $requirement): self
    {
        $this->requirement = $requirement;

        return $this;
    }

    /**
     * @return Collection<int, DiscoveryDay>
     */
    public function getDiscoveryDays(): Collection
    {
        return $this->discoveryDays;
    }

    public function addDiscoveryDay(DiscoveryDay $discoveryDay): self
    {
        if (!$this->discoveryDays->contains($discoveryDay)) {
            $this->discoveryDays->add($discoveryDay);
            $discoveryDay->setMinimumRank($this);
        }

        return $this;
    }

    public function removeDiscoveryDay(DiscoveryDay $discoveryDay): self
    {
        if ($this->discoveryDays->removeElement($discoveryDay)) {
            // set the owning side to null (unless already changed)
            if ($discoveryDay->getMinimumRank() === $this) {
                $discoveryDay->setMinimumRank(null);
            }
        }

        return $this;
    }
}
