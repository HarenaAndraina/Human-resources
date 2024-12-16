<?php

namespace App\Entity;

use App\Entity\Generic\AbstractNamedAndDescribedEntity;
use App\Entity\Recrutement\OffreEmploi;
use App\Repository\PosteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PosteRepository::class)]
class Poste extends AbstractNamedAndDescribedEntity
{
    #[ORM\Column(type: Types::TEXT)]
    private ?string $responsabilites = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $exigences = null;

    /**
     * @var Collection<int, OffreEmploi>
     */
    #[ORM\OneToMany(targetEntity: OffreEmploi::class, mappedBy: 'poste', orphanRemoval: true)]
    private Collection $offreEmplois;

    public function getResponsabilites(): ?string
    {
        return $this->responsabilites;
    }

    public function setResponsabilites(string $responsabilites): static
    {
        $this->responsabilites = $responsabilites;

        return $this;
    }

    public function getExigences(): ?string
    {
        return $this->exigences;
    }

    public function setExigences(string $exigences): static
    {
        $this->exigences = $exigences;

        return $this;
    }

    /**
     * @return Collection<int, OffreEmploi>
     */
    public function getOffreEmplois(): Collection
    {
        return $this->offreEmplois;
    }

    public function addOffreEmploi(OffreEmploi $offreEmploi): static
    {
        if (!$this->offreEmplois->contains($offreEmploi)) {
            $this->offreEmplois->add($offreEmploi);
            $offreEmploi->setPoste($this);
        }

        return $this;
    }

    public function removeOffreEmploi(OffreEmploi $offreEmploi): static
    {
        if ($this->offreEmplois->removeElement($offreEmploi)) {
            // set the owning side to null (unless already changed)
            if ($offreEmploi->getPoste() === $this) {
                $offreEmploi->setPoste(null);
            }
        }

        return $this;
    }

    public function __construct()
    {
        $this->offreEmplois = new ArrayCollection();
    }

    public function getPrefix(): string
    {
        return "POS";
    }

    public function getSequenceName(): string
    {
        return "id_poste_seq";
    }
}
