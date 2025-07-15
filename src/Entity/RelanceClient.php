<?php

namespace App\Entity;

use App\Repository\RelanceClientRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelanceClientRepository::class)]
class RelanceClient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTime $date = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $motif = null;

    #[ORM\ManyToOne(inversedBy: 'relanceClients')]
    private ?Stagiaire $stagiaire = null;

    #[ORM\ManyToOne(inversedBy: 'relanceClients')]
    private ?Commercial $commercial = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getStagiaire(): ?Stagiaire
    {
        return $this->stagiaire;
    }

    public function setStagiaire(?Stagiaire $stagiaire): static
    {
        $this->stagiaire = $stagiaire;

        return $this;
    }

    public function getCommercial(): ?Commercial
    {
        return $this->commercial;
    }

    public function setCommercial(?Commercial $commercial): static
    {
        $this->commercial = $commercial;

        return $this;
    }
}
