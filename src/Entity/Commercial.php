<?php

namespace App\Entity;

use App\Repository\CommercialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommercialRepository::class)]
class Commercial
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $telephone = null;

    /**
     * @var Collection<int, RelanceClient>
     */
    #[ORM\OneToMany(targetEntity: RelanceClient::class, mappedBy: 'commercial')]
    private Collection $relanceClients;

    public function __construct()
    {
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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

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
            $relanceClient->setCommercial($this);
        }

        return $this;
    }

    public function removeRelanceClient(RelanceClient $relanceClient): static
    {
        if ($this->relanceClients->removeElement($relanceClient)) {
            // set the owning side to null (unless already changed)
            if ($relanceClient->getCommercial() === $this) {
                $relanceClient->setCommercial(null);
            }
        }

        return $this;
    }
}
