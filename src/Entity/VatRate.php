<?php

namespace App\Entity;

use App\Repository\VatRateRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    normalizationContext: ['groups' => ['vat_rate:read']],
)]
#[ORM\Entity(repositoryClass: VatRateRepository::class)]
#[ORM\UniqueConstraint(name: "category_country_unique", columns: ["category_id", "country_id"])]
class VatRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['vat_rate:read', 'country:read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    #[Groups(['vat_rate:read', 'country:read'])]
    #[Assert\Range(
        min: 0,
        max: 20,
        notInRangeMessage: 'Range must be in range {{ min }} - {{ max }} %',
    )]
    #[Assert\NotBlank]
    #[Assert\Positive]
    #[Assert\Type('integer')]
    private ?string $rate = null;

    #[ORM\ManyToOne(inversedBy: 'vatRates')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['vat_rate:read'])]
    #[Assert\NotBlank]
    #[Assert\Type(Country::class)]
    private ?Country $country = null;

    #[ORM\ManyToOne(inversedBy: 'vatRates')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['vat_rate:read'])]
    #[Assert\NotBlank]
    #[Assert\Type(Category::class)]
    private ?Category $category = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(string $rate): static
    {
        $this->rate = $rate;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
    {
        $this->category = $category;

        return $this;
    }
}
