<?php

namespace App\Form;

use App\Entity\Animaux;
use App\Entity\Enclos;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AnimauxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Numero_identification')
            ->add('Nom')
            ->add('Date_naissance')
            ->add('Date_Arrivee_au_zoo')
            ->add('Date_de_Depart_du_zoo')
            ->add('le_zoo_en_es_proprietaire')
            ->add('Genre')
            ->add('Espece')
            ->add('Sexe', ChoiceType::class, [
            'choices'=> [
            'Male'=>'Male',
            'Femelle'=>'Femelle',
            'Non déterminé'=>'Non déterminé',
            ],
            'expanded'=> false,
            'multiple'=> false,
            ])
            ->add('Sterilise')
            ->add('EsEnQuarantaine')
            ->add('enclos', EntityType::class, [
                'class' => Enclos::class,
                'choice_label' => 'nom',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Animaux::class,
        ]);
    }
}
