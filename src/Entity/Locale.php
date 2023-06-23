<?php

namespace App\Entity;

use App\Repository\LocaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    normalizationContext: ['groups' => ['locale:read']],
)]
#[ORM\Entity(repositoryClass: LocaleRepository::class)]
class Locale
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['locale:read', 'country:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Groups(['locale:read', 'country:read'])]
    #[Assert\NotBlank]
    #[Assert\NoSuspiciousCharacters]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Locale name cannot be longer than {{ limit }} characters',
    )]
    #[Assert\Type(
        type: 'string',
        message: 'The value {{ value }} is not a valid {{ type }}.',
    )]
    private ?string $name = null;

    #[ORM\Column(length: 2, unique: true)]
    #[Groups(['locale:read', 'country:read'])]
    #[Assert\NotBlank]
    #[Assert\Length(
        max: 2,
        maxMessage: 'Locale name cannot be longer than {{ limit }} characters',
    )]
    #[Assert\Type('string')]
    private ?string $iso_code = null;

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

    public function getIsoCode(): ?string
    {
        return $this->iso_code;
    }

    public function setIsoCode(string $iso_code): static
    {
        $this->iso_code = $iso_code;

        return $this;
    }
}
