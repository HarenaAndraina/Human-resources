<?php

namespace App\Entity;

use App\Repository\DetailEvaluationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DetailEvaluationRepository::class)]
class DetailEvaluation
{
    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: Evaluation::class)]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: "id")]
    private Evaluation $evaluation;

    #[ORM\Column(type: "decimal", precision: 3, scale: 2, nullable: true)]
    private ?float $comportement;

    #[ORM\Column(type: "decimal", precision: 3, scale: 2, nullable: true)]
    private ?float $attitude;

    #[ORM\Column(type: "decimal", precision: 3, scale: 2, nullable: true)]
    private ?float $competence;

    #[ORM\Column(type: "decimal", precision: 3, scale: 2, nullable: true)]
    private ?float $connaissance;

    #[ORM\Column(type: "decimal", precision: 3, scale: 2, nullable: true)]
    private ?float $administrative;

    // Getters and Setters

    public function getEvaluation(): Evaluation
    {
        return $this->evaluation;
    }

    public function setEvaluation(Evaluation $evaluation): self
    {
        $this->evaluation = $evaluation;
        return $this;
    }

    public function getComportement(): ?float
    {
        return $this->comportement;
    }

    public function setComportement(?float $comportement): self
    {
        $this->comportement = $comportement;
        return $this;
    }

    public function getAttitude(): ?float
    {
        return $this->attitude;
    }

    public function setAttitude(?float $attitude): self
    {
        $this->attitude = $attitude;
        return $this;
    }

    public function getCompetence(): ?float
    {
        return $this->competence;
    }

    public function setCompetence(?float $competence): self
    {
        $this->competence = $competence;
        return $this;
    }

    public function getConnaissance(): ?float
    {
        return $this->connaissance;
    }

    public function setConnaissance(?float $connaissance): self
    {
        $this->connaissance = $connaissance;
        return $this;
    }

    public function getAdministrative(): ?float
    {
        return $this->administrative;
    }

    public function setAdministrative(?float $administrative): self
    {
        $this->administrative = $administrative;
        return $this;
    }

    public function getPrefix(): string
    {
        return "DTEVAL";
    }

    public function getSequenceName(): string
    {
        return "id_detail_evaluation_seq";
    }
}
