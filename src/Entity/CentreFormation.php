<?php

namespace App\Entity;

use App\Repository\CentreFormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Salle;

#[ORM\Entity(repositoryClass: CentreFormationRepository::class)]
class CentreFormation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $adresse = null;

    /**
     * @var Collection<int, Salle>
     */
    #[ORM\OneToMany(mappedBy: 'centreFormation', targetEntity: Salle::class)]
    private Collection $salles;

    public function __construct()
    {
        $this->salles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): static
    {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * @return Collection<int, Salle>
     */
    public function getSalles(): Collection
    {
        return $this->salles;
    }

    public function addSalle(Salle $salle): static
    {
        if (!$this->salles->contains($salle)) {
            $this->salles->add($salle);
            $salle->setCentreFormation($this);
        }

        return $this;
    }

    public function removeSalle(Salle $salle): static
    {
        if ($this->salles->removeElement($salle)) {
            if ($salle->getCentreFormation() === $this) {
                $salle->setCentreFormation(null);
            }
        }

        return $this;
    }
}
