<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SessionRepository::class)]
class Session
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string')]
    private string $etat = 'planifiee';

    #[ORM\Column]
    private ?\DateTime $date = null;

    
    #[ORM\Column]
    private ?float $prix = null;
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $intitule = null;
    #[ORM\Column]
    private ?int $minParticipants = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?Formation $formation = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?Salle $salle = null;

    #[ORM\ManyToOne(inversedBy: 'sessions')]
    private ?Formateur $formateur = null;

    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'session')]
    private Collection $inscriptions;

    /**
     * @var Collection<int, Evaluation>
     */
    #[ORM\ManyToMany(targetEntity: Evaluation::class, mappedBy: 'session')]
    private Collection $evaluations;

    /**
     * @var Collection<int, Alerte>
     */
    #[ORM\OneToMany(targetEntity: Alerte::class, mappedBy: 'Session')]
    private Collection $alertes;
    #[ORM\Column(type: 'integer')]
    private ?int $seuilMinimum = null;

    #[ORM\Column(length: 50)]
    private ?string $statut = 'en_attente';

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }



    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->evaluations = new ArrayCollection();
        $this->alertes = new ArrayCollection();
    }

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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): static
    {
        $this->prix = $prix;

        return $this;
    }

    public function getMinParticipants(): ?int
    {
        return $this->minParticipants;
    }

    public function setMinParticipants(int $minParticipants): static
    {
        $this->minParticipants = $minParticipants;

        return $this;
    }

    public function getFormation(): ?Formation
    {
        return $this->formation;
    }

    public function setFormation(?Formation $formation): static
    {
        $this->formation = $formation;

        return $this;
    }

    public function getSalle(): ?Salle
    {
        return $this->salle;
    }

    public function setSalle(?Salle $salle): static
    {
        $this->salle = $salle;

        return $this;
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

    /**
     * @return Collection<int, Inscription>
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): static
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions->add($inscription);
            $inscription->setSession($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getSession() === $this) {
                $inscription->setSession(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Evaluation>
     */
    public function getEvaluations(): Collection
    {
        return $this->evaluations;
    }

    public function addEvaluation(Evaluation $evaluation): static
    {
        if (!$this->evaluations->contains($evaluation)) {
            $this->evaluations->add($evaluation);
            $evaluation->addSession($this);
        }

        return $this;
    }

    public function removeEvaluation(Evaluation $evaluation): static
    {
        if ($this->evaluations->removeElement($evaluation)) {
            $evaluation->removeSession($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Alerte>
     */
    public function getAlertes(): Collection
    {
        return $this->alertes;
    }

    public function addAlerte(Alerte $alerte): static
    {
        if (!$this->alertes->contains($alerte)) {
            $this->alertes->add($alerte);
            $alerte->setSession($this);
        }

        return $this;
    }

    public function removeAlerte(Alerte $alerte): static
    {
        if ($this->alertes->removeElement($alerte)) {
            // set the owning side to null (unless already changed)
            if ($alerte->getSession() === $this) {
                $alerte->setSession(null);
            }
        }

        return $this;
    }


    public function getEtat(): string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;
        return $this;
    }

    public function getIntitule(): ?string
    {
        return $this->intitule;
    }

    public function setIntitule(string $intitule): self
    {
        $this->intitule = $intitule;
        return $this;
    }
    public function getSeuilMinimum(): ?int
{
    return $this->seuilMinimum;
}

public function setSeuilMinimum(int $seuilMinimum): static
{
    $this->seuilMinimum = $seuilMinimum;
    return $this;
}
}
