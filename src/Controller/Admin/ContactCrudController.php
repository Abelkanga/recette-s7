<?php

namespace App\Controller\Admin;

use App\Entity\Contact;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }



    public function configureCrud(Crud $crud): Crud
    {
        
        return $crud
        ->setEntityLabelInSingular("Demande de contact")
        ->setEntityLabelInPlural("Demande de contact")

        ->setPageTitle("index", "SymRecipe - Administration des demandes de contact")

        ->setPaginatorPageSize(20)
        
        // ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig')
        ;
    }

    
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->hideOnIndex(),
            TextField::new('fullName'),
            TextField::new('email'),
            TextareaField::new('message')

            
                ->setFormType(CKEditorType::class)
                ->hideOnIndex(),                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        
            DateTimeField::new('createdAt')
                ->hideOnForm(),
        ];
    }
    
}
