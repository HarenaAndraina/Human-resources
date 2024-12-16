<?php

namespace App\Dto;

final class PosteDTO
{
    public function __construct(
        public string $id,
        public string $nom,
        public string $description
    )
    { }
}
