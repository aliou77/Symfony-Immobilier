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