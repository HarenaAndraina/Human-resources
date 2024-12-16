<?php

namespace App\Entity\Recrutement;

use App\Entity\Generic\AbstractNamedAndDescribedEntity;
use App\Repository\Recrutement\EtapeRecrutementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EtapeRecrutementRepository::class)]
class EtapeRecrutement extends AbstractNamedAndDescribedEntity
{
    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $niveau = null;

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getPrefix(): string
    {
        return "ETRC";
    }

    public function getSequenceName(): string
    {
        return "id_etape_recrutement_seq";
    }
}
