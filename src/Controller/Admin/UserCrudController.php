<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Symfony\Component\Uid\Uuid;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    // CRÉER UNE UUID AUTOMATIQUEMENT QUE QUAND JE CRÉER UN UTILISATEUR DANS LE DASHBOARD
    public function createEntity(string $entityFqcn)
    {
        $user = new User();
        $user->setUuid(Uuid::v4());
        return $user;
    }
    
    
    
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('prenom'),
            TextField::new('email'),
            TextField::new('uuid')->hideOnForm(),
            ImageField::new('avatar')
                ->setBasePath('assets/uploads')
                ->setUploadDir('public/assets/uploads')
                ->setUploadedFileNamePattern("[randomhash].[extension]")
                ->setRequired(false)
            ,
            CollectionField::new('roles'),
        ];
    }
}
    