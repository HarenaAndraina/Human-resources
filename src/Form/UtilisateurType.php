<?php
namespace App\Form;
namespace App\Form;

use App\Entity\Utilisateur;
use App\Entity\Departement;
use App\Entity\Poste;
use App\Form\ContratType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'attr' => ['class' => 'form-control']
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'attr' => ['class' => 'form-control']
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'attr' => ['class' => 'form-control']
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Numéro de téléphone',
                'attr' => ['class' => 'form-control']
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => [
                    'Utilisateur' => 'ROLE_USER',
                    'Administrateur' => 'ROLE_ADMIN',
                ],
                'multiple' => true, // Permet de sélectionner plusieurs rôles
                'expanded' => false, // Affiche les choix sous forme de cases à cocher
                'label' => 'Rôles',
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateNaissance', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Date de naissance',
                'attr' => ['class' => 'form-control']
            ])
            ->add('debutActivite', DateType::class, [
                'widget' => 'single_text',
                'label' => 'Début d’activité',
                'attr' => ['class' => 'form-control']
            ])
            ->add('salaire', MoneyType::class, [
                'currency' => 'EUR',
                'label' => 'Salaire',
                'attr' => ['class' => 'form-control']
            ])
            ->add('departement', EntityType::class, [
                'class' => Departement::class,
                'choice_label' => 'nom',
                'label' => 'Département',
                'attr' => ['class' => 'form-control']
            ])
            ->add('poste', EntityType::class, [
                'class' => Poste::class,
                'choice_label' => 'nom', // Remplacez "nom" par le champ à afficher dans le dropdown
                'label' => 'Poste',
                'placeholder' => 'Sélectionner un poste',
                'attr' => ['class' => 'form-control']
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot de passe',
                'required' => true, // Obligatoire
                'attr' => ['class' => 'form-control']
            ])
            ->add('contrat', ContratType::class, [
                'label' => false, // Pas de label pour le sous-formulaire
            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
