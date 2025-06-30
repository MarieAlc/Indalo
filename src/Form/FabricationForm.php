<?php

namespace App\Form;

use App\Entity\DureeConsommation;
use App\Entity\Fabrication;
use App\Entity\ProduitFabrication;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FabricationForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('produit', EntityType::class, [
                'class' => ProduitFabrication::class,
                'choice_label' => 'nom',
            ])
            ->add('DureeConsomation', EntityType::class, [
                'class' => DureeConsommation::class,
                'choice_label' => function (DureeConsommation $duree) {
                    return $duree->getDuree() . ' H';
                },
                'label' => 'Durée de consommation',
            ])
             ->add('Submit', SubmitType::class,[
                'label' => 'Ajouter',
            ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fabrication::class,
        ]);
    }
}
