## SYMFONY REACT NOTE
# NB: React bundle not working properly, i use traditional method instead in React projects (see grafikart video).

-----------
# Dossier Config/Package
- contient des fichiers de configuracion .yaml specifique a chaque package. 

# fichier Config/service.yaml
allows you to set up a service and configure how it will be used.

# ========= COMMANDS =============

# php bin/console debug:autowiring
displays all services or classes that will be automaticly loaded when symfony server is started.

# NB: php bin/console will show all commands for more infos

# ========= AUTOWIRING =============
to use a service (class) just have to load his class like this:
Environment $twig;

# ========= DEBUG PACKAGISTS LIKE SECURITY =============
php bin/console config:dump-reference security => will show all configuration information inside security.yml file.


# ========= SET UP A SEARCH FORM =============
- create a ENTITY not linked to the database with fields u want to use
- create a form Type object then render it in the property.index controller
- and when data is submitted handle it in Repository then return the result data to the view controller.

# ========= MANY TO MANY LOGIC =============
- like database with many to many doctrine will create a new entity (table) to put 2 primary keys of two entities (Property and Option)
, exactly like u did in blog post TP with PHP Formation at the end.
# to create it :
- add a new property with make:entity Option named properties
- then select <relation> type
- and choose the ENTITY which Option entity will be related to
- and choose the relation type


# ========= MANY TO MANY LOGIC =============
- AssociationField::new('options')->hideOnIndex() in PropertyCrudController allow to add an association field inside the form
add the input field will be automatically guessed.


# ========= INPUTS validation =============
- using #[Assert\Range(min: 1, max:10 )] allows to make constraints in form fields before submitting form.
like : 
#[Assert\Range(min: 1, max:30 )]
#[ORM\Column]
private ?int $bedrooms = null;

# ========= INPUTS validation =============
- to see migrations status
php bin/console doctrine:migrations:status
- to go back to the previous migration
php bin/console doctrine:migrations:migrate DoctrineMigrations\Version20240228165928


# ========= BUG EASYADMIN FOR MANY TO MANY RELATIONS =============
/**
 * this function will return the name of each option converted to a string
 * to display it in the edit page admin (PropertyCrudController)
*/
public function __toString()
{
    return $this->name;
}


# ========= VICH UPLOADER + EASY ADMIN =============
- using ImageField will upload the image with EasyAdmin uploader file (image)
$uploadImgDir = dirname(__DIR__, 3) . '\public\images\properties';
ImageField::new('imageName')->setUploadDir($uploadImgDir)->hideOnIndex(),
# NB: u can use this to display the image in the properties page like this:
ImageField::new('imageName', 'images') // IT WILL JUST SHOW THE IMAGE FILE
    ->setUploadDir($uploadImgDir) // where img will be uploaded
    ->setUploadedFileNamePattern(fn(UploadedFile $file) => sprintf('upload_%s_%s.%s', date('d_m_Y'), $file->getFilename(), $file->guessExtension()))
    ->setBasePath('images/properties')->hideOnForm(), // will show the image in dashbord properties
    
- BUT using TextField will upload the image with VichUploader bundle
TextField::new('imageFile', 'Property Image')->setFormType(VichImageType::class)->hideOnIndex(),

# ========= BACK TO A MIGRATION =============
- php bin/console doctrine:migrations:status => See status of migrations and pick the previous migration
- php bin/console doctrine:migrations:migrate DoctrineMigrations\Version20240313180240 => then migrate to this version.

# ========= TEST COVERAGE =============
- link to confiure database test before doing functional tests
https://symfony.com/doc/current/testing.html#configuring-a-database-for-tests
- configure .env.test file
# and this line in .env.test.local file
DATABASE_URL="mysql://USERNAME:PASSWORD@127.0.0.1:3306/DB_NAME?serverVersion=5.7"
# then create the test database
php bin/console --env=test doctrine:database:create
# make all migrations
php bin/console --env=test doctrine:migrations:migrate
# and add all fixtures inside the test database
php bin/console --env=test doctrine:fixtures:load

- will generate a test coverage for all components of the application and will save it in test-coverage. 
php bin/phpunit --coverage-html var/log/test-coverage

# NB: to make it works gotta configure the php.ini used by the terminal, make a php -v to know what php.ini file to update the coverage option.

# Fonctional tests
for loading pages and other tests
php bin/console make:fonctional-test
# NB: to make functional test gotta create a new DB based on the current like agence_test




# ========= TASKS =============

==================
- add an option for sale or rent properties with bando on properties
here create a new property called PropertyTag for sale or rent with <ManyToOne> relation