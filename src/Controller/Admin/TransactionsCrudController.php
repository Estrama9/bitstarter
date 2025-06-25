<?php

namespace App\Controller\Admin;

use App\Entity\Transactions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;


class TransactionsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Transactions::class;
    }


    public function configureFields(string $pageName): iterable
    {
        // yield IdField::new('id')->hideOnForm();
        yield AssociationField::new('from_user')->setLabel('From');
        yield AssociationField::new('to_user')->setLabel('To');
        yield NumberField::new('amount_btc')->setLabel('BTC');;
        yield TextEditorField::new('message');
        if ($pageName === Crud::PAGE_INDEX) {
            yield DateTimeField::new('created_at')->setLabel('Creation Date');
        }
    }

}
