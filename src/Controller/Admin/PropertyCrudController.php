<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Entity\Property;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class PropertyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Property::class;
    }

    // to personalize the EasyAdmin dashboard layout 
    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            IntegerField::new('surface'),
            IntegerField::new('rooms'),
            IntegerField::new('bedrooms'),
            IntegerField::new('floor'),
            IntegerField::new('price'),
            BooleanField::new('sold'),
            IntegerField::new('heat')->hideOnIndex(),
            TextField::new('city')->hideOnIndex(),
            TextField::new('address')->hideOnIndex(),
            TextField::new('postal_code')->hideOnIndex(),
            DateField::new('created_at')->hideOnForm(),
            AssociationField::new('options')->hideOnIndex(), // gotta define __toString() in Option Entity file.
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['created_at' => 'DESC']);
    }
}
