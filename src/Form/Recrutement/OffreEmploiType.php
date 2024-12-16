<?php

namespace App\Form\Recrutement;

use App\Entity\Poste;
use App\Entity\Recrutement\OffreEmploi;
use App\Enum\StatutOffreEmploi;
use App\Form\DataTransformer\StatutOffreEmploiTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class OffreEmploiType extends AbstractType
{
    private StatutOffreEmploiTransformer $statutTransformer;

    public function __construct(StatutOffreEmploiTransformer $statutTransformer)
    {
        $this->statutTransformer = $statutTransformer;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                'attr' => ['placeholder' => 'Titre de l\'offre'],
            ])
            ->add('description', null, [
                'attr' => ['placeholder' => 'Description de l\'offre'],
            ])
            ->add('salaireMinimum', null, [
                'attr' => ['placeholder' => 'Salaire minimum'],
            ])
            ->add('salaireMaximum', null, [
                'attr' => ['placeholder' => 'Salaire maximum'],
            ])
            ->add('dateHeureCreation', null, [
                'widget' => 'single_text',
            ])
            ->add('dateExpiration', null, [
                'widget' => 'single_text',
            ])
            ->add('statut', ChoiceType::class, [
                'choices' => StatutOffreEmploi::getChoices(),
                'placeholder' => 'Choisir un statut',
            ])
            ->add('poste', EntityType::class, [
                'class' => Poste::class,
                'choice_label' => 'id',
            ]);

        $builder->get('statut')->addModelTransformer($this->statutTransformer);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OffreEmploi::class,
        ]);
    }
}
