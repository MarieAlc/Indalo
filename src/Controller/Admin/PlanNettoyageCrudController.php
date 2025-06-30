<?php

namespace App\Controller\Admin;

use App\Entity\PlanNettoyage;
use App\Repository\PlanNettoyageRepository;
use Doctrine\ORM\Query\FilterCollection;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PlanNettoyageCrudController extends AbstractCrudController
{

    private PlanNettoyageRepository $repository;

    public function __construct(PlanNettoyageRepository $repository)
    {
        $this->repository = $repository;
    }



    public static function getEntityFqcn(): string
    {
        return PlanNettoyage::class;
    }


    public function configureFields(string $pageName): iterable
    {
       return [
            IdField::new('id', 'ID')->onlyOnIndex(),
            TextField::new('nom', 'Nom'),
            AssociationField::new('reccurence', 'Récurrence'),
           
        ];
    }
}
