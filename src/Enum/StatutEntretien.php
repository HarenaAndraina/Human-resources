<?php

namespace App\Enum;

enum StatutEntretien: string
{
    case PLANIFIE = "Planifié";
    case ANNULE   = "Annulé";
    case ACCEPTE  = "Accepté";
    case REFUSE   = "Refusé";
}
