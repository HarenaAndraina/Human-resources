<?php

namespace App\Entity;

use App\Repository\TypeCongeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Generic\AbstractPrefixedIdEntity;

use App\Entity\Conge\DemandeConge;

#[ORM\Entity(repositoryClass: TypeCongeRepository::class)]
class TypeConge  extends AbstractPrefixedIdEntity
{
    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;

        return $this;
    }  
    public function getPrefix(): string
    {
        return "TCG";
    }

    public function getSequenceName(): string
    {
        return "id_type_conge_seq";
    }
}
