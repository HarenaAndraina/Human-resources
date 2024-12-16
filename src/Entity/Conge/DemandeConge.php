<?php

namespace App\Entity\Conge;

use App\Enum\StatutConge;
use App\Repository\Conge\DemandeCongeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Utilisateur;
use App\Entity\TypeConge;

#[ORM\Entity(repositoryClass: DemandeCongeRepository::class)]
class DemandeConge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'demandeConges')]
    #[ORM\JoinColumn(name:"id_utilisateur",nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne(inversedBy: 'demandeConges')]
    #[ORM\JoinColumn(name:"id_type_conge",nullable: false)]
    private ?TypeConge $typeConge = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_debut = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_fin = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(enumType:StatutConge::class)]
    private ?StatutConge $status = null;

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
    public function getId() : ?int{
        return $this->id;
    }

    public function setId(?int $id){
        $this->id=$id;
        return $this->id;
    } 

    public function getTypeConge(): ?TypeConge
    {
        return $this->typeConge;
    }

    public function setTypeConge(?TypeConge $typeConge): static
    {
        $this->typeConge = $typeConge;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): static
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): static
    {
        $this->date_fin = $date_fin;

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

    public function getStatus(): ?string
    {
        return $this->status ? $this->status->value : null;
    }

    public function setStatus(StatutConge $status): static
    {
        $this->status = $status;

        return $this;
    }
    
}
