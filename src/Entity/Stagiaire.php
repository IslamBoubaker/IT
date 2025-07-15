<?php

namespace App\Entity;

use App\Repository\StagiaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StagiaireRepository::class)]
class Stagiaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $diplome = null;

    #[ORM\Column(length: 255)]
    private ?string $prerequisValide = null;

    /**
     * @var Collection<int, Inscription>
     */
    #[ORM\OneToMany(targetEntity: Inscription::class, mappedBy: 'Stagiaire')]
    private Collection $inscriptions;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'Stagiaire')]
    private Collection $notes;

    /**
     * @var Collection<int, RelanceClient>
     */
    #[ORM\OneToMany(targetEntity: RelanceClient::class, mappedBy: 'Stagiaire')]
    private Collection $relanceClients;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->relanceClients = new ArrayCollection();
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getDiplome(): ?string
    {
        return $this->diplome;
    }

    public function setDiplome(string $diplome): static
    {
        $this->diplome = $diplome;

        return $this;
    }

    public function getPrerequisValide(): ?string
    {
        return $this->prerequisValide;
    }

    public function setPrerequisValide(string $prerequisValide): static
    {
        $this->prerequisValide = $prerequisValide;

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
            $inscription->setStagiaire($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): static
    {
        if ($this->inscriptions->removeElement($inscription)) {
            // set the owning side to null (unless already changed)
            if ($inscription->getStagiaire() === $this) {
                $inscription->setStagiaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Note>
     */
    public function getNotes(): Collection
    {
        return $this->notes;
    }

    public function addNote(Note $note): static
    {
        if (!$this->notes->contains($note)) {
            $this->notes->add($note);
            $note->setStagiaire($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getStagiaire() === $this) {
                $note->setStagiaire(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, RelanceClient>
     */
    public function getRelanceClients(): Collection
    {
        return $this->relanceClients;
    }

    public function addRelanceClient(RelanceClient $relanceClient): static
    {
        if (!$this->relanceClients->contains($relanceClient)) {
            $this->relanceClients->add($relanceClient);
            $relanceClient->setStagiaire($this);
        }

        return $this;
    }

    public function removeRelanceClient(RelanceClient $relanceClient): static
    {
        if ($this->relanceClients->removeElement($relanceClient)) {
            // set the owning side to null (unless already changed)
            if ($relanceClient->getStagiaire() === $this) {
                $relanceClient->setStagiaire(null);
            }
        }

        return $this;
    }
    
}
