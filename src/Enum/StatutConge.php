<?php

namespace App\Enum;

enum StatutConge: string
{
    case ATTENTE   = "En attente";
    case Approuve = "Approuve";
    case REFUSE  = "Refuse";

    public static function getChoices(): array
    {
        return [
            'En attente' => self::ATTENTE->value,
            'Approuve' => self::Approuve->value,
            'Refuse' => self::REFUSE->value,
        ];
    }
}
