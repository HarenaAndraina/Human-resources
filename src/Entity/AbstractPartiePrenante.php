<?php

namespace App\Entity;

use App\Entity\Generic\AbstractPrefixedIdEntity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\MappedSuperclass]
abstract class AbstractPartiePrenante extends AbstractPrefixedIdEntity
{
    #[ORM\Column(length: 70)]
    protected ?string $nom = null;

    #[ORM\Column(length: 70)]
    protected ?string $prenom = null;

    #[ORM\Column(length: 180)]
    protected ?string $email = null;

    #[ORM\Column(length: 255)]
    protected ?string $telephone = null;

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): static
    {
        $this->telephone = $telephone;

        return $this;
    }
}
