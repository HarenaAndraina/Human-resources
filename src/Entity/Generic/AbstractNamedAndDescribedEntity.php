<?php

namespace App\Entity\Generic;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\MappedSuperclass]
abstract class AbstractNamedAndDescribedEntity extends AbstractPrefixedIdEntity
{
    #[Assert\NotBlank(message: "Le nom est obligatoire")]
    #[ORM\Column(length: 255)]
    protected ?string $nom = null;

    #[Assert\NotBlank(message: "La description est obligatoire")]
    #[ORM\Column(length: 255)]
    protected ?string $description = null;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

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
}
