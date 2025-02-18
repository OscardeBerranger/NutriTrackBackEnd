<?php

namespace App\Entity;

use App\Repository\TrackingRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: TrackingRepository::class)]
class Tracking
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read', 'profile:read'])]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'tracking', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Profile $ofProfile = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    #[Groups(['user:read', 'profile:read'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    #[Groups(['user:read', 'profile:read'])]
    private ?float $consumedCalories = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOfProfile(): ?Profile
    {
        return $this->ofProfile;
    }

    public function setOfProfile(Profile $ofProfile): static
    {
        $this->ofProfile = $ofProfile;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getConsumedCalories(): ?float
    {
        return $this->consumedCalories;
    }

    public function setConsumedCalories(float $consumedCalories): static
    {
        $this->consumedCalories = $consumedCalories;

        return $this;
    }
}
