<?php

namespace App\Entity;

use App\Repository\FeedbackRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FeedbackRepository::class)]
class Feedback
{
    #[ORM\Id]
    #[ORM\OneToOne(targetEntity: Evaluation::class)]
    #[ORM\JoinColumn(nullable: false, referencedColumnName: "id")]
    private Evaluation $evaluation;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $positifAvis;

    #[ORM\Column(type: "text", nullable: true)]
    private ?string $critiqueAvis;

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

    public function getPositifAvis(): ?string
    {
        return $this->positifAvis;
    }

    public function setPositifAvis(?string $positifAvis): self
    {
        $this->positifAvis = $positifAvis;
        return $this;
    }

    public function getCritiqueAvis(): ?string
    {
        return $this->critiqueAvis;
    }

    public function setCritiqueAvis(?string $critiqueAvis): self
    {
        $this->critiqueAvis = $critiqueAvis;
        return $this;
    }

    public function getPrefix(): string
    {
        return "FDBK";
    }

    public function getSequenceName(): string
    {
        return "id_feedback_seq";
    }
}
