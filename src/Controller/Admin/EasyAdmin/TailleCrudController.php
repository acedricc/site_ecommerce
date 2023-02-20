<?php

namespace App\Controller\Admin\EasyAdmin;

use App\Entity\Taille;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;


class TailleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Taille::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setEntityLabelInPlural('Tailles')
        ->setEntityLabelInSingular('Tailles')
        ->setPageTitle('index', 'CedShop - Administration des tailles')
        ->setPaginatorPageSize(10)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
            ->hideOnForm(),
            TextField::new('size'),

        ];
    }
}
