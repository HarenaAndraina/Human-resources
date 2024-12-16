<?php

namespace App\Entity\Recrutement;

use App\Entity\AbstractPartiePrenante;
use App\Repository\Recrutement\CandidatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatRepository::class)]
class Candidat extends AbstractPartiePrenante
{
    #[ORM\Column(length: 255)]
    private ?string $nomFichierCV = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateCreation = null;

    /**
     * @var Collection<int, OffreEmploi>
     */
    #[ORM\ManyToMany(targetEntity: OffreEmploi::class, inversedBy: 'candidats')]
    private Collection $offreEmplois;

    public function __construct()
    {
        $this->offreEmplois = new ArrayCollection();
    }

    public function getNomFichierCV(): ?string
    {
        return $this->nomFichierCV;
    }

    public function setNomFichierCV(string $nomFichierCV): static
    {
        $this->nomFichierCV = $nomFichierCV;

        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;

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
        }

        return $this;
    }

    public function removeOffreEmploi(OffreEmploi $offreEmploi): static
    {
        $this->offreEmplois->removeElement($offreEmploi);

        return $this;
    }

    public function getPrefix(): string
    {
        return "CDT";
    }

    public function getSequenceName(): string
    {
        return "id_candidat_seq";
    }
}
