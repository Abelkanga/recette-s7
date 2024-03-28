<?php

namespace App\Entity;

use App\Repository\IngredienRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

// Déclaration de l'entité Ingredien avec son repository associé
#[ORM\Entity(repositoryClass: IngredienRepository::class)]
// Contrainte d'unicité sur le champ 'name'
#[UniqueEntity('name')]
class Ingredien
{
    // Identifiant de l'ingrédient
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Nom de l'ingrédient avec des contraintes de validation
    #[ORM\Column(length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(min: 2, max: 50)]
    private ?string $name = null;

    // Prix de l'ingrédient avec des contraintes de validation
    #[ORM\Column]
    #[Assert\NotNull()]
    #[Assert\Positive]
    #[Assert\LessThan(200)]
    private ?float $price = null;

    // Date de création de l'ingrédient
    #[ORM\Column]
    #[Assert\NotNull()]
    private ?\DateTimeImmutable $createdAt = null;

    // Utilisateur propriétaire de l'ingrédient
    #[ORM\ManyToOne(inversedBy: 'ingredien')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // Constructeur pour initialiser la date de création
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    // Méthodes d'accès aux propriétés de l'entité Ingredien

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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

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

    // Méthode magique pour représenter l'objet comme une chaîne de caractères (utilisé par exemple dans les formulaires)
    public function __toString()
    {
        return $this->name;
    }

    // Méthodes d'accès à l'utilisateur propriétaire de l'ingrédient

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
