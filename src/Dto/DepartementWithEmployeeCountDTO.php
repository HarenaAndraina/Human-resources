<?php

namespace App\Dto;

final class DepartementWithEmployeeCountDTO
{
    public function __construct(
        public string $id,
        public string $nom,
        public string $description,
        public int $nombreEmployes,
    )
    { }
}
