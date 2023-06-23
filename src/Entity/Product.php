<?php

namespace App\Entity;

use App\Controller\ProductController;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Metadata\Get;


#[ApiResource(
    normalizationContext: ['groups' => ['product:read']],
)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/product_price/{id}/{iso_code}',
            routeName: 'api_product_price',
            controller: ProductController::class,
        ),
    ]
)]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product:read', 'category:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['product:read', 'category:read'])]
    #[Assert\NotBlank]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Product name cannot be longer than {{ limit }} characters',
    )]
    #[Assert\Type('string')]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['product:read', 'category:read'])]
    #[Assert\NotBlank]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Type('string')]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Groups(['product:read', 'category:read'])]
    #[Assert\NotBlank]
    #[Assert\Positive]
    #[Assert\Type('integer')]
    private ?string $price = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['product:read'])]
    #[Assert\NotBlank]
    #[Assert\Type(Category::class)]
    private ?Category $category = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(string $price): static
    {
        $this->price = $price;

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
