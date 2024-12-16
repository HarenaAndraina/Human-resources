<?php

namespace App\Form\Recrutement;

use App\Entity\Recrutement\Candidat;
use App\Entity\Recrutement\OffreEmploi;
use App\Repository\Recrutement\OffreEmploiRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CandidatType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
            ->add('telephone')
            ->add('nomFichierCV')
            ->add('offreEmplois', EntityType::class, [
                'class' => OffreEmploi::class,
                'choice_label' => function (OffreEmploi $offreEmploi) {
                    return (string) $offreEmploi;
                },
                'query_builder' => function (OffreEmploiRepository $offreEmploiRepository) {

                },
                'multiple' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Candidat::class,
        ]);
    }
}
