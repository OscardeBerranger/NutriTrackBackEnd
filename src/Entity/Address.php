<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['address:read'])]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['address:read'])]
    private ?int $streetNumber = null;

    #[ORM\Column(length: 255)]
    #[Groups(['address:read'])]
    private ?string $street = null;

    #[ORM\Column]
    #[Groups(['address:read'])]
    private ?int $zipcode = null;

    #[ORM\Column(length: 255)]
    #[Groups(['address:read'])]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    #[Groups(['address:read'])]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $flatInfo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStreetNumber(): ?int
    {
        return $this->streetNumber;
    }

    public function setStreetNumber(int $streetNumber): static
    {
        $this->streetNumber = $streetNumber;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): static
    {
        $this->street = $street;

        return $this;
    }

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    public function setZipcode(int $zipcode): static
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getFlatInfo(): ?string
    {
        return $this->flatInfo;
    }

    public function setFlatInfo(?string $flatInfo): static
    {
        $this->flatInfo = $flatInfo;

        return $this;
    }
}
