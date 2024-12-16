<?php

namespace App\Entity\Recrutement;

use App\Entity\Utilisateur;
use App\Enum\StatutEntretien;
use App\Enum\TypeEntretien;
use App\Repository\Recrutement\EntretienRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntretienRepository::class)]
class Entretien
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeureCreation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateHeurePrevue = null;

    #[ORM\Column(enumType: StatutEntretien::class)]
    private ?StatutEntretien $statut = null;

    #[ORM\Column(enumType: TypeEntretien::class)]
    private ?TypeEntretien $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $commentaires = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Candidat $candidat = null;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\ManyToMany(targetEntity: Utilisateur::class)]
    #[ORM\JoinTable(
        name: "entretien_recruteur",
        joinColumns: [
            new ORM\JoinColumn(name: "id_entretien")
        ],
        inverseJoinColumns: [
            new ORM\JoinColumn(name: "id_recruteur")
        ]
    )]
    private Collection $recruteurs;

    public function __construct()
    {
        $this->recruteurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateHeurePrevue(): ?\DateTimeInterface
    {
        return $this->dateHeurePrevue;
    }

    public function setDateHeurePrevue(\DateTimeInterface $dateHeurePrevue): static
    {
        $this->dateHeurePrevue = $dateHeurePrevue;

        return $this;
    }

    public function getStatut(): ?StatutEntretien
    {
        return $this->statut;
    }

    public function setStatut(StatutEntretien $statut): static
    {
        $this->statut = $statut;

        return $this;
    }

    public function getType(): ?TypeEntretien
    {
        return $this->type;
    }

    public function setType(TypeEntretien $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getCommentaires(): ?string
    {
        return $this->commentaires;
    }

    public function setCommentaires(?string $commentaires): static
    {
        $this->commentaires = $commentaires;

        return $this;
    }

    public function getCandidat(): ?Candidat
    {
        return $this->candidat;
    }

    public function setCandidat(Candidat $candidat): static
    {
        $this->candidat = $candidat;

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getRecruteurs(): Collection
    {
        return $this->recruteurs;
    }

    public function addRecruteur(Utilisateur $recruteur): static
    {
        if (!$this->recruteurs->contains($recruteur)) {
            $this->recruteurs->add($recruteur);
        }

        return $this;
    }

    public function removeRecruteur(Utilisateur $recruteur): static
    {
        $this->recruteurs->removeElement($recruteur);

        return $this;
    }
}
