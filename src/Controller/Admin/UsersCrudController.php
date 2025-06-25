<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class UsersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Users::class;
    }


    public function configureFields(string $pageName): iterable

    {

    yield TextField::new('username')->setLabel('Users');
    yield TextField::new('email')->setLabel('Email');
    yield ArrayField::new('roles')->setLabel('Roles');

    if ($pageName === Crud::PAGE_NEW) {
        yield TextField::new('plainPassword')
            ->onlyOnForms()
            ->setHelp('Laissez le champ ci-dessus vide pour conserver le mot de passe');
    }

    yield BooleanField::new('is_verified')->setLabel('Verified');
    yield DateTimeField::new('created_at')->setLabel('Creation Date');
}

}
