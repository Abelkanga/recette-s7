<?php

namespace App\Controller\Admin;

use App\Entity\User;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureCrud(Crud $crud): Crud 
    {
        return $crud
            ->setEntityLabelInPlural("Utilisateurs")
            ->setEntityLabelInSingular("Utilisateur")

            ->setPageTitle("index", "SymRecipe - Administration des utilisateurs")

            ->setPaginatorPageSize(10);

    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnForm(),
            TextField::new('fullName'),
            TextField::new('pseudo'),
            TextField::new('email'),
                // ->hideOnForm(),
            ArrayField::new('roles')
                ->hideOnIndex(),
            DateTimeField::new('createdAt')
                ->hideOnForm()
               
        ];
    }
    
    
}
