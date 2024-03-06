<?php

namespace App\Controller\Admin;

use App\Entity\Option;
use App\Entity\Property;
use App\Form\PropertyImageType;
use DateTime;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\DomCrawler\Field\FileFormField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\Date;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;

class PropertyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Property::class;
    }

    // to personalize the EasyAdmin dashboard layout 
    public function configureFields(string $pageName): iterable
    {
        $uploadImgDir = dirname(__DIR__, 3) . DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR .'images'.DIRECTORY_SEPARATOR.'properties';
        return [
            TextField::new('imageFile', 'Property Image')->setFormType(VichImageType::class)->hideOnIndex(),
            ImageField::new('imageName', 'images') // IT WILL JUST SHOW THE IMAGE FILE
                ->setUploadDir($uploadImgDir) // where img will be uploaded
                ->setUploadedFileNamePattern(fn(UploadedFile $file) => sprintf('upload_%s_%s.%s', date('d_m_Y'), $file->getFilename(), $file->guessExtension()))
                ->setBasePath('images/properties')->hideOnForm(), // will show the image in dashbord properties
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
