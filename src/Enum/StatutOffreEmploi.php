<?php

namespace App\Enum;

enum StatutOffreEmploi: string
{
    case CREEE   = "Créée";
    case PUBLIEE = "Active";
    case FERMEE  = "Fermée";

    public static function getChoices(): array
    {
        return [
            'Créée' => self::CREEE->value,
            'Publiée' => self::PUBLIEE->value,
            'Fermée' => self::FERMEE->value,
        ];
    }
}
