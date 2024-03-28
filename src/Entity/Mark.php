<?php

namespace App\Entity;

use App\Repository\MarkRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

// Déclaration de l'entité Mark avec son repository associé
#[ORM\Entity(repositoryClass: MarkRepository::class)]
// Contrainte d'unicité sur les champs 'user' et 'recipe'
#[UniqueEntity(
    fields: ['user', 'recipe'],
    errorPath: 'user',
    message: 'Cet utilisateur a déjà noté cette recette.'
)]
class Mark
{
    // Identifiant de la note
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    // Note attribuée à la recette avec des contraintes de validation
    #[ORM\Column]
    #[Assert\Positive(6)]
    #[Assert\LessThan]
    private ?int $mark = null;

    // Utilisateur ayant donné la note
    #[ORM\ManyToOne(inversedBy: 'marks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // Recette notée
    #[ORM\ManyToOne(inversedBy: 'marks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Recipe $recipe = null;

    // Date de création de la note
    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    // Constructeur pour initialiser la date de création
    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    // Méthodes d'accès aux propriétés de l'entité Mark

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMark(): ?int
    {
        return $this->mark;
    }

    public function setMark(int $mark): static
    {
        $this->mark = $mark;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getRecipe(): ?Recipe
    {
        return $this->recipe;
    }

    public function setRecipe(?Recipe $recipe): static
    {
        $this->recipe = $recipe;

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
}
