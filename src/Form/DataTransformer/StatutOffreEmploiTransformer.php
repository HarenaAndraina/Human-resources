<?php 
namespace App\Form\DataTransformer;

use App\Enum\StatutOffreEmploi;
use Symfony\Component\Form\DataTransformerInterface;

class StatutOffreEmploiTransformer implements DataTransformerInterface
{

    public function transform(mixed $value): mixed
    {
        return $value ? $value->value : null; // This ensures we pass the string value to the form
    }

    public function reverseTransform(mixed $value): mixed
    {
        return $value ? StatutOffreEmploi::from($value) : null; // Convert the string back to enum
    }
}
