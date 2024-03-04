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


# ========= TASKS =============
- Redesign search input based on template 
- design errors layout
- when designing property layout include displaying options
- display errors and success messages

