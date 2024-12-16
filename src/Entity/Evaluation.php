<?php

namespace App\Entity;

use App\Repository\EvaluationRepository;
use Doctrine\ORM\Mapping as ORM;
use DateTime;

#[ORM\Entity(repositoryClass: EvaluationRepository::class)]
class Evaluation
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 255)]
    private string $id;

    #[ORM\Column(type: "date")]
    private DateTime $dateEvaluation;

    #[ORM\Column(type: "decimal", precision: 5, scale: 2, nullable: true)]
    private ?float $scoreMoyenne;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: "id", name:"utilisateur_id")]
    private Utilisateur $utilisateur;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class)]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: "id", name:"juge_id")]
    private Utilisateur $juge;


    // Getters and Setters

    public function getDateEvaluation(): DateTime
    {
        return $this->dateEvaluation;
    }

    public function setDateEvaluation(DateTime $dateEvaluation): self
    {
        $this->dateEvaluation = $dateEvaluation;
        return $this;
    }

    public function getScoreMoyenne(): ?float
    {
        return $this->scoreMoyenne;
    }

    public function setScoreMoyenne(?float $scoreMoyenne): self
    {
        $this->scoreMoyenne = $scoreMoyenne;
        return $this;
    }

    public function getJuge(): Utilisateur
    {
        return $this->juge;
    }

    public function setJuge(Utilisateur $juge): self
    {
        $this->juge = $juge;
        return $this;
    }

    public function getId() : ?string{
        return $this->id;
    }

    public function setId(?string $id){
        $this->id=$id;
        return $this->id;
    } 

    public function getUtilisateur(): Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getPrefix(): string
    {
        return "EVAL";
    }

    public function getSequenceName(): string
    {
        return "id_evaluation_seq";
    }
}
