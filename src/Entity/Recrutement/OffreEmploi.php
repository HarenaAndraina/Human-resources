<?php

namespace App\Entity\Recrutement;

use App\Entity\Poste;
use App\Enum\StatutOffreEmploi;
use App\Repository\Recrutement\OffreEmploiRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OffreEmploiRepository::class)]
class OffreEmploi
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 18, scale: 2, nullable: true)]
    private ?string $salaireMinimum = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 18, scale: 2, nullable: true)]
    private ?string $salaireMaximum = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeureCreation = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateExpiration = null;

    #[ORM\Column(enumType: StatutOffreEmploi::class)]
    private ?StatutOffreEmploi $statut = null;

    #[ORM\ManyToOne(inversedBy: 'offreEmplois')]
    #[ORM\JoinColumn(name: "id_poste", nullable: false)]
    private ?Poste $poste = null;

    /**
     * @var Collection<int, Candidat>
     */
    #[ORM\ManyToMany(targetEntity: Candidat::class, mappedBy: 'offreEmplois')]
    private Collection $candidats;

    /**
     * @var Collection<int, EtapeRecrutementCandidat>
     */
    #[ORM\OneToMany(targetEntity: EtapeRecrutementCandidat::class, mappedBy: 'offreEmploi', orphanRemoval: true)]
    private Collection $etapesRecrutementCandidats;

    public function __construct()
    {
        $this->candidats = new ArrayCollection();
        $this->etapesRecrutementCandidats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getSalaireMinimum(): ?string
    {
        return $this->salaireMinimum;
    }

    public function setSalaireMinimum(?string $salaireMinimum): static
    {
        $this->salaireMinimum = $salaireMinimum;

        return $this;
    }

    public function getSalaireMaximum(): ?string
    {
        return $this->salaireMaximum;
    }

    public function setSalaireMaximum(?string $salaireMaximum): static
    {
        $this->salaireMaximum = $salaireMaximum;

        return $this;
    }

    public function getDateHeureCreation(): ?\DateTimeInterface
    {
        return $this->dateHeureCreation;
    }

    public function setDateHeureCreation(\DateTimeInterface $dateHeureCreation): static
    {
        $this->dateHeureCreation = $dateHeureCreation;

        return $this;
    }

    public function getDateExpiration(): ?\DateTimeInterface
    {
        return $this->dateExpiration;
    }

    public function setDateExpiration(?\DateTimeInterface $dateExpiration): static
    {
        $this->dateExpiration = $dateExpiration;

        return $this;
    }

    public function getStatut(): ?string
    {
        // Check if statut is not null and return the string value of the enum
        return $this->statut ? $this->statut->value : null;
    }

    public function setStatut(StatutOffreEmploi $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getPoste(): ?Poste
    {
        return $this->poste;
    }

    public function setPoste(?Poste $poste): static
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * @return Collection<int, Candidat>
     */
    public function getCandidats(): Collection
    {
        return $this->candidats;
    }

    public function addCandidat(Candidat $candidat): static
    {
        if (!$this->candidats->contains($candidat)) {
            $this->candidats->add($candidat);
            $candidat->addOffreEmploi($this);
        }

        return $this;
    }

    public function removeCandidat(Candidat $candidat): static
    {
        if ($this->candidats->removeElement($candidat)) {
            $candidat->removeOffreEmploi($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, EtapeRecrutementCandidat>
     */
    public function getEtapesRecrutementCandidats(): Collection
    {
        return $this->etapesRecrutementCandidats;
    }

    public function addEtapeRecrutementCandidat(EtapeRecrutementCandidat $etapeRecrutementCandidat): static
    {
        if (!$this->etapesRecrutementCandidats->contains($etapeRecrutementCandidat)) {
            $this->etapesRecrutementCandidats->add($etapeRecrutementCandidat);
            $etapeRecrutementCandidat->setOffreEmploi($this);
        }

        return $this;
    }

    public function removeEtapeRecrutementCandidat(EtapeRecrutementCandidat $etapeRecrutementCandidat): static
    {
        if ($this->etapesRecrutementCandidats->removeElement($etapeRecrutementCandidat)) {
            // set the owning side to null (unless already changed)
            if ($etapeRecrutementCandidat->getOffreEmploi() === $this) {
                $etapeRecrutementCandidat->setOffreEmploi(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return sprintf("%s - %s", $this->titre, $this->dateHeureCreation);
    }
}
