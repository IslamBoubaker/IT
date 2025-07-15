<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
class Evaluation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column]
    private ?\DateTime $date = null;

    /**
     * @var Collection<int, Session>
     */
    #[ORM\ManyToMany(targetEntity: Session::class, inversedBy: 'evaluations')]
    private Collection $session;

    /**
     * @var Collection<int, Note>
     */
    #[ORM\OneToMany(targetEntity: Note::class, mappedBy: 'evaluation')]
    private Collection $notes;

    public function __construct()
    {
        $this->session = new ArrayCollection();
        $this->notes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
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

    /**
     * @return Collection<int, Session>
     */
    public function getSession(): Collection
    {
        return $this->session;
    }

    public function addSession(Session $session): static
    {
        if (!$this->session->contains($session)) {
            $this->session->add($session);
        }

        return $this;
    }

    public function removeSession(Session $session): static
    {
        $this->session->removeElement($session);

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
            $note->setEvaluation($this);
        }

        return $this;
    }

    public function removeNote(Note $note): static
    {
        if ($this->notes->removeElement($note)) {
            // set the owning side to null (unless already changed)
            if ($note->getEvaluation() === $this) {
                $note->setEvaluation(null);
            }
        }

        return $this;
    }
}
