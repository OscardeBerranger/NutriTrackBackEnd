<?php

namespace App\Entity;

use App\Repository\ProfileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: ProfileRepository::class)]
class Profile
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read', 'profile:read'])]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'profile', cascade: ['persist', 'remove'])]
    private ?User $ofUser = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:read', 'profile:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['user:read', 'profile:read'])]
    private ?string $surname = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['user:read', 'profile:read'])]
    private ?int $height = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['user:read', 'profile:read'])]
    private ?int $weight = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['user:read', 'profile:read'])]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['user:read', 'profile:read'])]
    private ?float $sportFrequecy = null;


    #[Groups(['user:read', 'profile:read'])]
    #[ORM\ManyToOne(inversedBy: 'profiles')]
    private ?Gender $gender = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;


    #[Groups(['user:read', 'profile:read'])]
    #[ORM\OneToOne(mappedBy: 'ofProfile', cascade: ['persist', 'remove'])]
    private ?Tracking $tracking = null;

    #[ORM\Column(nullable: true)]
    private ?int $phoneNumber = null;

    /**
     * @var Collection<int, Address>
     */
    #[ORM\ManyToMany(targetEntity: Address::class)]
    #[Groups(['profile:read'])]
    private Collection $address;

    /**
     * @var Collection<int, Ingredient>
     */
    #[ORM\ManyToMany(targetEntity: Ingredient::class)]
    private Collection $allergies;

    public function __construct()
    {
        $this->address = new ArrayCollection();
        $this->allergies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOfUser(): ?User
    {
        return $this->ofUser;
    }

    public function setOfUser(?User $ofUser): static
    {
        $this->ofUser = $ofUser;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function setHeight(?int $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(?int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(?\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getSportFrequecy(): ?float
    {
        return $this->sportFrequecy;
    }

    public function setSportFrequecy(?float $sportFrequecy): static
    {
        $this->sportFrequecy = $sportFrequecy;

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): static
    {
        $this->gender = $gender;

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

    public function getAge(){
        $today = new \DateTime();
        $interval = $this->birthDate->diff($today);

        return $interval->y;
    }

    public function getTracking(): ?Tracking
    {
        return $this->tracking;
    }

    public function setTracking(Tracking $tracking): static
    {
        // set the owning side of the relation if necessary
        if ($tracking->getOfProdile() !== $this) {
            $tracking->setOfProdile($this);
        }

        $this->tracking = $tracking;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection<int, Address>
     */
    public function getAddress(): Collection
    {
        return $this->address;
    }

    public function addAddress(Address $address): static
    {
        if (!$this->address->contains($address)) {
            $this->address->add($address);
        }

        return $this;
    }

    public function removeAddress(Address $address): static
    {
        $this->address->removeElement($address);

        return $this;
    }

    /**
     * @return Collection<int, Ingredient>
     */
    public function getAllergies(): Collection
    {
        return $this->allergies;
    }

    public function addAllergy(Ingredient $allergy): static
    {
        if (!$this->allergies->contains($allergy)) {
            $this->allergies->add($allergy);
        }

        return $this;
    }

    public function removeAllergy(Ingredient $allergy): static
    {
        $this->allergies->removeElement($allergy);

        return $this;
    }
}
