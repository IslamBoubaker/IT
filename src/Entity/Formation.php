<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $FicheFormation = null;

    /**
     * @var Collection<int, SousTheme>
     */
    #[ORM\ManyToMany(targetEntity: SousTheme::class, inversedBy: 'formations')]
    private Collection $SousTheme;

    /**
     * @var Collection<int, Session>
     */
    #[ORM\OneToMany(targetEntity: Session::class, mappedBy: 'formation')]
    private Collection $sessions;

    public function __construct()
    {
        $this->SousTheme = new ArrayCollection();
        $this->sessions = new ArrayCollection();
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

    public function getFicheFormation(): ?string
    {
        return $this->FicheFormation;
    }

    public function setFicheFormation(string $FicheFormation): static
    {
        $this->FicheFormation = $FicheFormation;

        return $this;
    }

    /**
     * @return Collection<int, SousTheme>
     */
    public function getSousTheme(): Collection
    {
        return $this->SousTheme;
    }

    public function addSousTheme(SousTheme $sousTheme): static
    {
        if (!$this->SousTheme->contains($sousTheme)) {
            $this->SousTheme->add($sousTheme);
        }

        return $this;
    }

    public function removeSousTheme(SousTheme $sousTheme): static
    {
        $this->SousTheme->removeElement($sousTheme);

        return $this;
    }

    /**
     * @return Collection<int, Session>
     */
    public function getSessions(): Collection
    {
        return $this->sessions;
    }

    public function addSession(Session $session): static
    {
        if (!$this->sessions->contains($session)) {
            $this->sessions->add($session);
            $session->setFormation($this);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        if ($this->sessions->removeElement($session)) {
            // set the owning side to null (unless already changed)
            if ($session->getFormation() === $this) {
                $session->setFormation(null);
            }
        }

        return $this;
    }
}
