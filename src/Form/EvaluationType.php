<?php
namespace App\Form;

use App\Entity\Evaluation;
use App\Entity\Utilisateur;
use App\Form\DetailEvaluationType; // Assurez-vous d'importer ce type
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvaluationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $excludedUserId = $options['excluded_user_id'];

        $builder
            ->add('dateEvaluation', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date d\'évaluation',
            ])
            ->add('juge', EntityType::class, [
                'class' => Utilisateur::class,
                'choice_label' => 'nom',
                'query_builder' => function ($er) use ($excludedUserId) {
                    return $er->createQueryBuilder('u')
                        ->where('u.id != :excludedUserId')
                        ->setParameter('excludedUserId', $excludedUserId);
                },
                'label' => 'Juge',
                'placeholder' => 'Sélectionnez un juge',
            ])
            ->add('detailEvaluation', DetailEvaluationType::class, [
                'mapped' => false, 
                'label' => false, 
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evaluation::class,
            'excluded_user_id' => null,
        ]);
    }
}
