<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    normalizationContext: ['groups' => ['category:read']],
    denormalizationContext: ['groups' => ['category:write']],
)]
#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['category:read', 'product:read', 'vat_rate:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['category:read', 'category:write', 'product:read', 'vat_rate:read'])]
    #[Assert\NotBlank]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Category name cannot be longer than {{ limit }} characters',
    )]
    #[Assert\Type('string')]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: Product::class, orphanRemoval: true)]
    #[Groups(['category:read'])]
    private Collection $products;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: VatRate::class, orphanRemoval: true)]
    private Collection $vatRates;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getCategory() === $this) {
                $product->setCategory(null);
            }
        }

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
            $vatRate->setCategory($this);
        }

        return $this;
    }

    public function removeVatRate(VatRate $vatRate): static
    {
        if ($this->vatRates->removeElement($vatRate)) {
            // set the owning side to null (unless already changed)
            if ($vatRate->getCategory() === $this) {
                $vatRate->setCategory(null);
            }
        }

        return $this;
    }
}
