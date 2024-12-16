<?php

namespace App\Entity;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use App\Repository\TypeContratRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypeContratRepository::class)]
class TypeContrat extends AbstractPrefixedIdEntity
{
    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $dureeMinimum = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    private ?int $dureeMaximum = null;

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }

    public function getDureeMinimum(): ?int
    {
        return $this->dureeMinimum;
    }

    public function setDureeMinimum(?int $dureeMinimum): static
    {
        $this->dureeMinimum = $dureeMinimum;

        return $this;
    }

    public function getDureeMaximum(): ?int
    {
        return $this->dureeMaximum;
    }

    public function setDureeMaximum(?int $dureeMaximum): static
    {
        $this->dureeMaximum = $dureeMaximum;

        return $this;
    }

    public function getPrefix(): string
    {
        return "TCTR";
    }

    public function getSequenceName(): string
    {
        return "id_type_contrat_seq";
    }
}
