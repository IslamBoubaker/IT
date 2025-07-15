<?php

namespace App\Entity;
use App\Entity\Session;
use App\Repository\ChecklistLogistiqueRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChecklistLogistiqueRepository::class)]
class ChecklistLogistique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $reservationSalle = null;

    #[ORM\Column]
    private ?bool $machinesInstallees = null;

    #[ORM\Column]
    private ?bool $formateurConfirme = null;

    #[ORM\Column]
    private ?bool $supportsImprimes = null;

    #[ORM\Column]
    private ?bool $convocationsEnvoyees = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Session $Session = null;

    #[ORM\Column]
    private ?bool $estActive = null;

    #[ORM\Column]
    private ?bool $salleReservee = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isReservationSalle(): ?bool
    {
        return $this->reservationSalle;
    }

    public function setReservationSalle(bool $reservationSalle): static
    {
        $this->reservationSalle = $reservationSalle;

        return $this;
    }

    public function isMachinesInstallees(): ?bool
    {
        return $this->machinesInstallees;
    }

    public function setMachinesInstallees(bool $machinesInstallees): static
    {
        $this->machinesInstallees = $machinesInstallees;

        return $this;
    }

    public function isFormateurConfirme(): ?bool
    {
        return $this->formateurConfirme;
    }

    public function setFormateurConfirme(bool $formateurConfirme): static
    {
        $this->formateurConfirme = $formateurConfirme;

        return $this;
    }

    public function isSupportsImprimes(): ?bool
    {
        return $this->supportsImprimes;
    }

    public function setSupportsImprimes(bool $supportsImprimes): static
    {
        $this->supportsImprimes = $supportsImprimes;

        return $this;
    }

    public function isConvocationsEnvoyees(): ?bool
    {
        return $this->convocationsEnvoyees;
    }

    public function setConvocationsEnvoyees(bool $convocationsEnvoyees): static
    {
        $this->convocationsEnvoyees = $convocationsEnvoyees;

        return $this;
    }

    public function getSession(): ?Session
    {
        return $this->Session;
    }

    public function setSession(?Session $Session): static
    {
        $this->Session = $Session;

        return $this;
    }

    public function isEstActive(): ?bool
    {
        return $this->estActive;
    }

    public function setEstActive(bool $estActive): static
    {
        $this->estActive = $estActive;

        return $this;
    }

    public function isSalleReservee(): ?bool
    {
        return $this->salleReservee;
    }

    public function setSalleReservee(bool $salleReservee): static
    {
        $this->salleReservee = $salleReservee;

        return $this;
    }
}
