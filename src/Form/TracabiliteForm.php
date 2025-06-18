<?php

namespace App\Form;

use App\Entity\DureeConsommation;
use App\Entity\Tracabilite;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TracabiliteForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('produit')
            ->add('photo', FileType::class, [
                'label' => 'Photo du produit (JPG, JPEG ou PNG uniquement)',
                'mapped' => false, // car ce n'est pas une propriété de l'entité directement
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/jpg',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide (JPG, JPEG ou PNG)',
                    ])
                ],
            ])
            ->add('duree', EntityType::class, [
                'label' => 'Durée de consommation',
                'class' => DureeConsommation::class,
                'choice_label' => function($duree) {
                    return $duree->getDuree() . ' H';
                },
                
            ])
            ->add('Submit', SubmitType::class,[
                'label' => 'Ajouter',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tracabilite::class,
        ]);
    }
}
