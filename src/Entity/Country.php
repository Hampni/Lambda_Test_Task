<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    normalizationContext: ['groups' => ['country:read']],
    denormalizationContext: ['groups' => ['country:write']],
)]
#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ORM\UniqueConstraint(name: "locale_unique", columns: ["locale_id"])]
class Country
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['country:read', 'vat_rate:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['country:read', 'country:write', 'vat_rate:read'])]
    #[Assert\NotBlank]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Country name cannot be longer than {{ limit }} characters',
    )]
    #[Assert\Type('string')]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'country', targetEntity: VatRate::class, orphanRemoval: true)]
    #[Groups(['country:read'])]
    private Collection $vatRates;

    #[ORM\ManyToOne(targetEntity: Locale::class)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['country:read',  'country:write',])]
    #[Assert\NotBlank]
    #[Assert\Type(Locale::class)]
    private ?Locale $locale = null;

    public function __construct()
    {
        $this->vatRates = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, VatRate>
     */
    public function getVatRates(): Collection
    {
        return $this->vatRates;
    }

    public function addVatRate(VatRate $vatRate): static
    {
        if (!$this->vatRates->contains($vatRate)) {
            $this->vatRates->add($vatRate);
            $vatRate->setCountry($this);
        }

        return $this;
    }

    public function removeVatRate(VatRate $vatRate): static
    {
        if ($this->vatRates->removeElement($vatRate)) {
            // set the owning side to null (unless already changed)
            if ($vatRate->getCountry() === $this) {
                $vatRate->setCountry(null);
            }
        }

        return $this;
    }

    public function getLocale(): ?Locale
    {
        return $this->locale;
    }

    public function setLocale(?Locale $locale): static
    {
        $this->locale = $locale;

        return $this;
    }
}
