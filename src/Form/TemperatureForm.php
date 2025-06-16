<?php

namespace App\Form;

use App\Entity\Materiel;
use App\Entity\Temperature;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TemperatureForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('valeur', null, [
                'label' => 'Degrés Celsius',
                'attr' => [
                    'placeholder' => 'Entrez la température',
                ],
            ])
            ->add('materiel', EntityType::class, [
                'class' => Materiel::class,
                'choice_label' => 'nom', 
                'label' => 'Matériel utilisé',
                'placeholder' => 'Choisissez un matériel',
            ])
            ->add('Submit', SubmitType::class,
            [
                 'label' => 'Valider'

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Temperature::class,
        ]);
    }
}
