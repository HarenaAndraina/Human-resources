<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

class DetailEvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comportement', NumberType::class)
            ->add('attitude', NumberType::class)
            ->add('competence', NumberType::class)
            ->add('connaissance', NumberType::class)
            ->add('administrative', NumberType::class);
    }
}
