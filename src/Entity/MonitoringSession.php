<?php

namespace App\Entity;

use App\Repository\MonitoringSessionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MonitoringSessionRepository::class)]
class MonitoringSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $etatSalle = null;

    #[ORM\Column(length: 255)]
    private ?string $etatSupports = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Session $session = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEtatSalle(): ?string
    {
        return $this->etatSalle;
    }

    public function setEtatSalle(string $etatSalle): static
    {
        $this->etatSalle = $etatSalle;

        return $this;
    }

    public function getEtatSupports(): ?string
    {
        return $this->etatSupports;
    }

    public function setEtatSupports(string $etatSupports): static
    {
        $this->etatSupports = $etatSupports;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->session;
    }

    public function setSession(?Session $session): static
    {
        $this->session = $session;

        return $this;
    }
}
