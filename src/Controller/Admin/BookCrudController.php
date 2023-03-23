<?php

namespace App\Controller\Admin;

use App\Entity\Book;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BookCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Book::class;
    }


    // CRUD (CREATE READ UPDATE DELETE) DANS LE DASHBOARD
    // 
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextField::new('author'),
            IntegerField::new('isbn'),
            BooleanField::new('isAvailable'),
            TextareaField::new('resume'),
            ImageField::new('cover')
                ->setBasePath('assets/uploads')
                ->setUploadDir('public/assets/uploads')
                ->setUploadedFileNamePattern("[randomhash].[extension]")
                ->setRequired(false)
            ,
            AssociationField::new('idCategory'),
            AssociationField::new('idBox'),
        ];
    }
}