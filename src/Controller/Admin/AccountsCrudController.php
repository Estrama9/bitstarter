<?php

namespace App\Controller\Admin;

use App\Entity\Accounts;
use App\Enum\AccountType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class AccountsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Accounts::class;
    }


    public function configureFields(string $pageName): iterable
    {

        // yield IdField::new('id')->hideOnForm();
        yield AssociationField::new('user')->setLabel('Users');
        yield NumberField::new('amount_btc')->setLabel('BTC');
        yield ChoiceField::new('type')
            ->setLabel('Accounts')
            ->setChoices([
                'Checking' => AccountType::CHECKING,
                'Savings' => AccountType::SAVINGS,
            ])
            ->renderExpanded(false) // dropdown
            ->renderAsNativeWidget();
        if ($pageName === Crud::PAGE_INDEX) {
            yield DateTimeField::new('created_at')->setLabel('Creation Date');
        }



    }

}
