/////////////// Routing //////////////////////////////
- creer une route dans route.yaml
- ou creer une route en commentaire de la methode qui rendra la vue

= AbstractController permet de faire un rendu plus simple de la vue, avec la methode render() qui return la vue 
ex: return this->render('index.html.twig') 

////////////// BASE DE DONNEE - DOCTRINE ////////////////////
- configuration de la DB sur Symfony
se rendre dans .env pour ajouter les informations du server DB a utiliser

- utilisation de bin/console (doctrine) pour la manipulation de la DB avec 'Doctrine:'
= bin/console doctrine:database:create => cree une base de donne qui aura comme nom celui mit dans le .env

- creation et manupulation des tables et champs de la DB avec 'Make:'
= make:entity => creer une table et une class portant le mm nom pour interagir avec les champs de la table creer 
# NB: 
 Property => est une classe qui contient les champs de la table et leurs parametre
 PropertyRepository => est une classe qui va permetre de creer des requette sql et interagir avec la DB en recuperant    les donnees ou en les Updatant.
= make:migration => creer un fichier contenant les commandes effectuer precedement (creation de la db, table, et les champs) qui vont etre stocker dans le dossier <Migrations>
# NB: 
 c'est ce fichier qui sera utiliser pour envoyer les commandes sql qui s'y trouve a la DB pour qu'il effectue les opperations de creation (la DB, table (property), et les champs).
 il faut verifier si les commandes sont ce que veux executer dans la DB, ils peuvent etre corriger sinon avant d'effectuer la migration vers la DB.
= doctrine:migration:migrate => envoie les commandes sql se trouvant dans le fichie de migration creer precedement a la   DB.
= make:entity Property => cree la table Property si elle n'existe pas, sinon on vous demande d'y rajouter des champs pour ensuite effectuer un migration et modifier facilement des champs de la table.

# EntityManager:
est une classe qui permet de gerer les entity, gerer l'ajout ou l'update des donnees dans DB
- utilisation d'EntityManager: pour l'utiliser il faut injecter EntityManagerInterface dans la methode voulue 

class ProductController extends AbstractController
{
    #[Route('/product', name: 'create_product')]
    public function createProduct(EntityManagerInterface $entityManager): Response
    {
        $product = new Product();
        $product->setName('Keyboard');
        $product->setPrice(1999);
        $product->setDescription('Ergonomic and stylish!');

        // tell Doctrine you want to (eventually) save the Product (no queries yet)
        $entityManager->persist($product);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new product with id '.$product->getId());
    }
}
# Termes a connaitres:
Entity: est une classe qui va representer une table dans la DB
fields: champs dans la table

# Fetch les donnees depuis la DB
NB: en gros il recupere une instance du PropertyRepository
# methode 1:
utiliser EntityManager dans la methode.
public function property(EntityManagerInterface $em):{
    $products = $em->getRepository(Property::class);
    $products->find(1); // 1 = id du property

}
# methode 2:
c'est d'injecter le PropertyRepository dans le PropertyController directement

private $repository; // definir une propriete

public function __construct(PropertyRepository $repository)
{
    $this->repository = $repository; // et l'instancier pour pouvoir l'utiliser partout dans la classe
}

# utilisation de Slugify pour convertir les chaine en slug et les donnees en param
composer require cocur/slugify 

//////////// CREATION DE FORMULAIRE ////////////////////
php bin/console make:form => creer un form. ensuite:
- donner le nom du form tjrs se terminer par 'Type'
- et donner la class qui represente la table cibler (ou les donnees seront mis a jour) dans la DB ici c'est <Property>
# NB: 
la classe <PropertyType> est celle qui gere la creation du formulaire pour l'Entite <Property>

= Pour utiliser ce form et le rendre a la vue il faut utiliser dans la methode <edite> (la ou le form sera utiliser)
la methode $this->createForm() et on prend son retour pour l'envoyer a la vue.
ex: $form = $this->createForm(PropertyType::class, $property);
# NB:
ne pas directement renvoyer le form, il faut proceder ainsi
$form->createView() // cree une vue qui peut etre renvoyer la vue

= Pour afficher le formulaire dans la vue twig on utilise:
{{ form_start(form)}}
    {{ form_rest(form)}} // => affiche le form
{{ form_end(form)}}

#NB: 
pour personaliser l'affichage des champs et utiliser bootstrap 5 il faut ajouter dans config/pakages/twig.yaml ceux ci:
form_themes: ['bootstrap_5_layout.html.twig']

= ou aussi morcauler manuellement l'affichage en utilisant les {{form_row(form.title) }}

//////////////// modification des labels des champs ////////////////
# NB: il faut avant tout installer <composer require symfony/intl> pour la gestion des langues du framwork
1er methode:
ajouter dans la methode du PropertyType
$resolver->setDefaults([
    'data_class' => Property::class,
    'translation_domain' => 'forms' // pour utiliser le systeme de tradition contenu dans le fichier Translations/forms.yaml
]);

puis creer une le forms.fr.yaml dans le dossier <Translation>
puis modifier la langue local dans <config/pakages/translation.yaml> et mettre fr
# NB: touts les traduction misent dans forms.fr.yaml seront afficher dans les labels du formulaire
 ### POUR MOI LA 2EM METHODE NE FONTIONNE PAS :( 

//////////////// MESSAGES FLASH ////////////////////////////
lorsqu'un flash est ajouter, il est stoker dans un objet<Array> app.flashes('type')
il faudra parcour le tableau et afficher le msg a l'endroit voulu.
ex: app.flashes('success')

/////////////////// VALIDATION DES DONNEES DU FORMULAIRE ////////////////////////
pour utiliser les contraintes il faut se rendre dans l'entite <Property> et definir les contrainte sur les proprietes voulu.
ex: 
#[ORM\Column(length: 255)]
#[Assert\Regex("/^[0-9]{5}$/")] // ajout d'une contrainte pour le code postal qui ne recoit que des nombres et max: 5
private ?string $postal_code = null;

////////////////////  LE COMPOSANT DE SECURITE //////////////////////////
interdiction des users a la partie admin du site, pour cela il faut d'abord creer une table user via doctrine
php bin/console make:entity User
php bin/console make:migration
php bin/console doctrine:migrations:migrate

# NB: la configuration de la securite est dans le fichier config/pakagest/security.yaml
c'est ce fichier qu'il faut modifier pour configurer la securite du site
# NB: il faut ajouter l'entite User dans <password_hashers:> et le parametrage des options algoritm sont automatiqe
ex: 
when@test:
    security:
        password_hashers:
            # c'est ici qu'il faut ajouter la classe User connecter a la DB pour pouvoir hasher les passwords
            # l'entite App\Entity\User.
            App\Entity\User: auto

- php bin/console config:dump-reference security => permet d'afficher toutes les configurations du composant <security>
# NB: cette commande aussi montre les attribut a utiliser dans la configuration du security.yaml

= pour ajouter un nouveau utilisateur dans la DB dont le password sera hasher avec Bcrypt on utilise les fixtures.
# NB: les fixutres sont des composants qui permet d'ajouter des faux donnees dans la DB
php bin/console make:fixtures 
- apres avoir ecrit le code d'ajout du user dans UserFixtures on les envoie a la DB via bin/console
php bin/console doctrine:fixtures:load --append => pour qu'il ne purge (effacer toute la DB) mais qu'il ajoute

////////////// LA DECONNEXION DU USER ///////////////////
il suffit just de creer une route vers /logout dans route.yaml sans definir de methode qui renvoie une Response
et l'ajouter dans la configuration de security.yaml

/////////////// PAGINATION DES BIEN //////////////////////
- remplissage de la DB en utilsant FAKER (composer require faker), pour pouvoir effectuer la pagination des biens
en utilisant les Fixtures.
<PropertyFixtures> est le fixture utiliser pour la remplissage de la table property

- composer require knplabs/knp-paginator-bundle sera le bundle utiliser pour la pagination des biens
- configuration de paginator:
 creer un config/pakages/knp_paginator.yaml et y ajouter la config dans la doc du bundle github
 modifier les templetes d'affichage en choisissant bootstrap 5 NB: se baser a la doc sur gitHub

# CONSEPTE A SAVOIRE:
- autowiring: c'est le fait d'injecter des dependence directement sur une class ou sur une methode d'une classe et utiliser les methodes de l'objet injecter.
cela est possible selement si symfony a garder en memoire la classe (namespace) dans la list des autowring
commande pour savoir si une class peut etre utiliser comme autowiring:
php bin/console debug:autowiring

NB: pour la traduction marche parfois il faut vider le cache et recharger la page pour les changement s'effectuent
php bin/console cache:clear

## IMPORTANT :
pour que l'application soit fast dans le chargement IL FAUT VIDER LE CACHE TOUT LE TEMPS.

////////////// SYSTEMDE DE FILTRAGE DES BIENS ////////////////////
- il faut d'abord creer une Entity pour la recherche dans le form (ici c'est PropertySearch) qui ne va pas extends de
AbstracController vu qu'il ne sera pa lier a une table de la DB.
- puis faire un make:form et lier le formulaire a cette Entity NB: utiliser <\App\Entity\PropertySearch> parce que L'ORM ne connait pas cette Entity.
- apres il faut gerer le traitement et l'affichage du form dans le PropetyController::property() methode

# NB: lors de la recherche si les donnees des champs ne sont pas comforme au regles ils ne seront pas soumit
symfony va bloquer la soumission.

///////////////// GESTION DES OPTIONS //////////////////////
Creer des options pour les biens dans la DB pour pouvoir mieux les categoriser.
1- creer une entity options et y mettre les champs make:entity
options(name, properties);
- properties: sera de type relation et fera reference a la class Property, et on utilisera la relation ManuToMany

# NB: TYPE DE RELATIONS DANS UNE BASE DE DONNE
ManyToOne => chaqne options est relier (relates) a UN SEUL Bien.
             et Chaque Bien est relier a PLUSIEURS options. 
             ex: une option peut appartenir a plusieurs articles, et un article peut etre relier a plusieurs options

OneToMany => chaqne options est relier (relates) a PLUSIEURS Bien.
             et Chaque Bien est relier a UNE SEUL option.
             ex: une categorie peut appartenir a plusieurs articles, et un article peut appartenir qu'a une seule categorie

ManyToMany => chaqne options est relier (relates) a PLUSIEURS Bien.
             et chaqne bien est relier (relates) a PLUSIEURS options.
             ex: une option peut appartenir a plusieurs articles, et un article peut etre relier a plusieurs options

OneToOne => chaqne options est relier (relates) a exactement UN SEUL Bien.
            chaqne bien est relier (relates) a exactement UNE SEUL Option.
            ex: une persone ne peu posseceder qu'un seul profile, et un profile ne peut appartenir qu'a une seul personne

- puis effectuer une migration des modifications a la DB
# NB: pour ajouter une option a un bien:
il suffi d'initialiser un new Option() et l'ajouter dans la proprieter au niveau du controller des bien AdminPropertyController.

# NB: on peut creer un Controller via la console et aussi tout le CRUD avec :
- make:crud Option => creer un CRUD qui se referera a l'entite Option
- make:contoller

====== Relier les options aux biens :
- ajouter un nouveau champs dans le AdminPropertyType de type options pour pouvoir selectionner les options pour chaque bien.

============================
        WARNING
============================
apres la creation et la configuration du ManyToMany s'il ya un probleme lors de la soumission du formulaire pour editer une propriete sur la selection des options DISANT que: le champs 'name' ne peut pas etre vide
Il faut just activer sur le champs name comme etant NULLABLE dans la table <options>.
----------------------------

# NB: retourner a une migration anterieure:
doctrine:migration:status => affiche les derneres migrations faites
doctrine:migration:migrate <id_migration(ex: 787899998877788)> => retourne vers cette migration et modifie la DB en consequence.


///////////////////////// IMAGE A LA UNE /////////////////////////////////

Utiliser un bundle pour la gestion de l'image sur symfony. qui est : <composer require vich/uploader-bundle>
NB: site officile des bundles compatible a 100% a symfony est <flex-symfony.com>

- apres l'installation du bundle il faut le configurer et creer un nouveau mapping qui servira a mapper les dossier pour l'upload des images.
- puis lier l'entite et le uploader-bundle en ajoutant une property dans la classe <Property>
- faire une migration des mofications faites dans <Property> (imageName, imageSize) pour les ajouter ces champs dans la DB.
make:migration
php bin/console doctrine:migrations:migrate => migrer les modifications
- en suite modifier le formulaire de <edite> d'une propriete pour ajouter le champs image.

# NB: 
pour que l'image puisse etre updated il faut persister le champs file du formulaire, pour le faire il faut creer une proprieter updated_at pour enregistrer la date de l'update de l'image comme ca a chaque fois que cette date changera la persistance au niveau de la DB sera automatiquement effectuer.
il faut passer par la console:
make:entity Property => pour ajouter un nouveau champs.

# NB: pour que l'upload fonctionne il faut aussi ajouter <#[Vich\Uploadable]> en haut de la class <Property>
====== 
namer: Vich\UploaderBundle\Naming\SmartUniqueNamer => permet de modifier le nom du fichier image et l'affecter un id unique et on a just a l'ajouter dans <vich_uploader.yaml> et la modification se fera automatiquement.
======
composer require liip/imagine-bundle => permet de mettre en cache les images uploader sur le DOM pour gagner en performance

//////////////// FORMULAIRE DE CONTACT //////////////////////////
- il faut dabord creer l'entity Contact manuellement et ne doit pas extends de AbstractController parce qu'il ne sera pa lier a la DB a Doctrine. 
- ensuite creer le formulaire make:form et choisir l'entity Contact
- injecter le form dans la rendu et effectuer le traitement des datas soumisent avec le handleRequest()

////////////// Symfony encore, utilisatin du javascript de maniere dynamique avec WEBPACK ////////////////////////
# regarder dans le projet Immobilier2




////////////////////// PROBLEME N+1 - PERFORMANCE LIER AU ONE-TO-MANY //////////////////////////////////////////
le probleme:
one to many: un bien peut etre associer a plusieurs images 

apres avoir recuperer tous les bien, dans la vue twig on lui demande d'afficher l'image, le title, ou prix du bien
du coup l'orm se dit qu'il ne les connais pas et donc il fait fait une nouvelle requette pour recuperer les infos
dans la DB pour afficher chaque information demander pour CHAQUE BIEN C'EST FOU NON ...?, et a la fin on se retrouve avec plus de requette et affecte la perfomance du site.

# 3 SOLUTIONS POUR REMIDIER AU PROBLEME:
- solution 1:
utilisation des EAGER qui permetra d'effectuer les requette dans la DB avant le chargement de la page, il suffit 
d'ajouter sur la propriete ayant le ONE-TO-MANY une valeur <fetch='EAGER'>.
avec l'EAGER l'orm fait un left join pour recuperer toutes les infomations requises title, img, price.
# NB: mais le mieux c'est de le definir sois meme dans PropertyRepository pour eviter de le modifier a chaque qu'on en aura besoin.
- solution 2:
mettre en cache le rendu twig pour ne pas faire de rendu a chaque requete, en utilisant le bundle 
<twig/cache-extension>.
apres son installation on ajoute les services au niveau du services.yaml puis on utilise la balise <cache> de twig
et entouter avec tout le code du templete (voir la doc sur le bundle).
- solution 3:
manuellement hydrater les chose, modifier les requettes dans <PropertyRepository> et optimiser la logique des requettes et on a comme ca le controle total du systeme et si un jour je veux modifier la maniere de recuperer les images ca sera plus facile.

///////////////////////// Creation d'un bundle personnel /////////////////////
un bundle qui sera reutiliser de projet en projet. il se trouvera dans lib/RecaptchaBundle
# actions a effectuer:
- indiquer pour le chargement du namespace, ajouter le namespace dans <composer.json> au niveau de <autoload>
puis mettre a jour l'autoloader de composer: composer dump-autoload.
- ajouter le bundle dans config/bundles.php pour qu'il soit charger par l'orm, ['all' => true] (c'est pour le mettre pour touts les environements).
- creer notre propre type de champs dans lib/Type
- ajouter un champs du type RecaptchaType dans le form de contact
- on doit modifier le type de champ pour ne pas afficher un input pour cela on cree une vue twig /Ressources/view/field.html.twig
# NB: en creant le dossier Ressource twig va generer automatiquement un namespace quui pointe directement dans ce dossier pour le voir: debug:twig

- dans le field.html.twig on definir comment rendre notre button recaptcha dans la vue form contact
- apres il faut ajouter le chemin de la vue submit au form pour le faire il faut l'ajouter dans le tableau de parametre pour qu'il soit charger automatique par le framwork, et c'est ainsi que tous les bundle comme VichUploader fonctionne dans le framework.
- il faut donc modifier le container de symfony via le RecaptchaBundle
# NB: il ne faut pas se gourer dans le nom <Resources> si non le namespace @Recaptcha ne s'affichera pas 
# NB: UN SEUL CARACTERE OUBLIER PEUT BOUSIER LE CODE ET TU NE VERA JAMAIS LE RESULTAT ATTENDU

- @Recaptcha\/field.html.twig => ce chemin va permettre de definir le prefix du block 'recaptchat_submit' dans field.html.twig et afficher le button

- creer un recaptcha.yaml pour la recuperation des cle et pour les injecter dans la vue field.html.twig
- le framework ne sait pas comment charger notre extention apres l'avoir creer donc il faudra creer un fichier au mm niveau que <RecaptchaExtention> un fichier <Configuration.php>
# NB: il faut ajouter une propriete dans RecaptchaSubmitType avec le meme nom que l'enfant dans recaptcha.yaml et l'initialiser
- apres avoir fini de definir la configuration du fichier recaptcha.yaml dans <Configuration.php> se rendre dans 
<RecaptchaExtention> pour demander le container de symfony de charger les configurations dans le framwork

############ WARNIG: t'a galerer a trouver le bug parceque tu fait pas attention a ce que tu ecrit cretin :)
aulieu du namespace Aliou\RecaptchaBundle\DependencyInjection t'a mis Aliou\RecaptchaBundle\RecaptchaInjection;;
#########################

- creer Resources/config/services.yaml ou le bundle pourra declarer lui meme ces propres services.
et y mettre la configuration du service
- ensuite il faudra dire au systeme de le charger, pour le faire on se rend dans RecaptchaExtension

#################
    Commandes
#################
php bin/console debug:container --tags => permet d'afficher tous les tags
php bin/console debug:container --tag=form.type => permet d'afficher un tag 







