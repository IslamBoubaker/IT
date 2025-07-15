<?php

namespace App\Entity;

use App\Repository\FormateurValidationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormateurValidationRepository::class)]
class FormateurValidation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Formateur $formateur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateValidation = null;

    #[ORM\Column]
    private ?bool $techniquementValide = null;

    #[ORM\Column]
    private ?bool $pedagogiquementValide = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaire = null;

    #[ORM\Column]
    private ?bool $premiereFois = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): static
    {
        $this->formateur = $formateur;

        return $this;
    }

    public function getDateValidation(): ?\DateTimeInterface
    {
        return $this->dateValidation;
    }

    public function setDateValidation(\DateTimeInterface $dateValidation): static
    {
        $this->dateValidation = $dateValidation;

        return $this;
    }

    public function isTechniquementValide(): ?bool
    {
        return $this->techniquementValide;
    }

    public function setTechniquementValide(bool $techniquementValide): static
    {
        $this->techniquementValide = $techniquementValide;

        return $this;
    }

    public function isPedagogiquementValide(): ?bool
    {
        return $this->pedagogiquementValide;
    }

    public function setPedagogiquementValide(bool $pedagogiquementValide): static
    {
        $this->pedagogiquementValide = $pedagogiquementValide;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): static
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function isPremiereFois(): ?bool
    {
        return $this->premiereFois;
    }

    public function setPremiereFois(bool $premiereFois): static
    {
        $this->premiereFois = $premiereFois;

        return $this;
    }
}
