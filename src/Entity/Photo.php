<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[
    ORM\Entity(repositoryClass: PhotoRepository::class),
    ORM\Table(name: 'photo')
]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $filename = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $uploadedAt = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    #[ORM\JoinColumn(name: 'uploaded_by', referencedColumnName: 'id', nullable: false)]
    private ?User $uploadedBy = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    #[ORM\JoinColumn(name: 'discovery_day', referencedColumnName: 'id', nullable: false)]
    private ?DiscoveryDay $discoveryDay = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): null|string|UploadedFile
    {
        return $this->filename;
    }

    public function setFilename(string|UploadedFile $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    public function getUploadedAt(): ?\DateTimeImmutable
    {
        return $this->uploadedAt;
    }

    public function setUploadedAt(\DateTimeImmutable $uploadedAt): self
    {
        $this->uploadedAt = $uploadedAt;

        return $this;
    }

    public function getUploadedBy(): ?User
    {
        return $this->uploadedBy;
    }

    public function setUploadedBy(?User $uploadedBy): self
    {
        $this->uploadedBy = $uploadedBy;

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
}
