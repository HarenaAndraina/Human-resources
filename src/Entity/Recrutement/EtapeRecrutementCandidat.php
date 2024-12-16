<?php

namespace App\Entity\Recrutement;

use App\Repository\Recrutement\EtapeRecrutementCandidatRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtapeRecrutementCandidatRepository::class)]
class EtapeRecrutementCandidat
{
    #[ORM\Id]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "id_candidat", nullable: false)]
    private ?Candidat $candidat = null;

    #[ORM\Id]
    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: "id_etape_recrutement", nullable: false)]
    private ?EtapeRecrutement $etape = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'etapeRecrutementCandidats')]
    #[ORM\JoinColumn(name: "id_offre_emploi", nullable: false)]
    private ?OffreEmploi $offreEmploi = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $motif = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeure = null;

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(?Candidat $candidat): static
    {
        $this->candidat = $candidat;

        return $this;
    }

    public function getEtape(): ?EtapeRecrutement
    {
        return $this->etape;
    }

    public function setEtape(?EtapeRecrutement $etape): static
    {
        $this->etape = $etape;

        return $this;
    }

    public function getOffreEmploi(): ?OffreEmploi
    {
        return $this->offreEmploi;
    }

    public function setOffreEmploi(?OffreEmploi $offreEmploi): static
    {
        $this->offreEmploi = $offreEmploi;

        return $this;
    }

    public function getMotif(): ?string
    {
        return $this->motif;
    }

    public function setMotif(?string $motif): static
    {
        $this->motif = $motif;

        return $this;
    }

    public function getDateHeure(): ?\DateTimeInterface
    {
        return $this->dateHeure;
    }

    public function setDateHeure(\DateTimeInterface $dateHeure): static
    {
        $this->dateHeure = $dateHeure;

        return $this;
    }
}
