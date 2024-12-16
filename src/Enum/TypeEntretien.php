<?php

namespace App\Enum;

enum TypeEntretien: string
{
    case PRESENTIEL   = "Présentiel";
    case TELEPHONIQUE = "Téléphonique";
    case VIDEO        = "Vidéo";
    case AUTRES       = "Autre";
}
