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


# ========= INPUTS validation
- using #[Assert\Range(min: 1, max:10 )] allows to make constraints in form fields before submitting form.
like : 
#[Assert\Range(min: 1, max:30 )]
#[ORM\Column]
private ?int $bedrooms = null;




# ========= TASKS =============
- Redesign search input based on template 
- design errors layout