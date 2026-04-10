<?php

namespace App\Controllers;
use App\Models\User;
use App\Models\Article;
use App\Utils\AbstractController;

class ArticleController extends AbstractController
{
    // Méthode pour ajouter un article
    public function addArticle()
    {
        //si la session existe et que la personne est bien connectée
        if(isset($_SESSION['user'])){
            //s'il existe un post dans mon formulaire d'inscription addArticle (lorsque l'utilisateur a envoyé le post)
            if(isset($_POST['addArticle'])){
                //la fonction htmlspecialchars() convertit certains caractères prédéfinis en entités HTML (en chaînes de caractères) pour prévenir les attaques XSS alors ajoute-moi le titre et le texte crées par l'utilisateur
                $title = htmlspecialchars($_POST['title']);
                $text = htmlspecialchars($_POST['article']);
                $this->Check('title', $text);
                $this->Check('article', $text);

                //on appelle notre tableau d'erreur, si celui-ci est vide alors on ajoute le titre et l'article si une session existe et que la personne est connectée
                if(empty($this->arrayError)){
                    $article = new Article(null, $title, $text, $_SESSION['user']['id_user']);
                    $article->addArticle();
                    $this->redirectToRoute('/', 200);
                }
            }
            require_once(__DIR__ . "/../Views/addArticle.view.php");
        }else{
            $this->redirectToRoute('/', 302);
        }    
    }

    // Méthode pour afficher tous les articles
    public function getAllArticles()
    {
        //On vérifie si un utilisateur est connecté (présent dans la session)
        if(isset($_SESSION['user'])){
            //instanciation d'un nouvel objet article avec des valeurs nulles (on passes les 4 arguments null au constructeur sans lui donner de valeurs pour l'instant)
            $article = new Article(null, null, null, null);
            //on appelle notre méthode getAllArticles (qui vient du model article.php) pour avoir un résultat
            $myArticles = $article->getAllArticles(); // tableau d'objets Article

        // ✅ On boucle sur chaque article pour récupérer son auteur
        $authors = [];
        foreach ($myArticles as $art){
            //$art->getIdUser() → récupère l’ID de l’auteur de l’article
            $user = new User($art->getIdUser(), null, null, null, null, null);
            //On appelle getUserById() pour récupérer les infos de l’utilisateur
            $authors[$art->getIdUser()] = $user->getUserById();
        }

            require_once(__DIR__ . "/../Views/articles.view.php");
        } else {
        $this->redirectToRoute('/', 302);
        }
    }

    // Méthode pour afficher un article par son id
    public function getArticleById()
    {
        //Vérifie si le paramètre 'id' existe dans l'URL (méthode GET), le code ici ne s'exécute que si 'id' est présent, exemple d'URL : affichArticle?id=1
        if(isset($_GET['id'])){
            //Récupère la valeur 'id' depuis l'URL ($_GET) puis convertit les caractères spéciaux en entités HTML pour éviter les injections de code HTML/JavaScript (XSS)
            $id = htmlspecialchars($_GET['id']);
            //Création d'un nouvel objet de la classe Article, on appelle le constructeur de la classe avec 4 paramètres (on donne l'id et 3 arguments null)
            $article = new Article($id, null, null, null);
            //On appelle notre méthode getArticleById (qui vient du model article.php) pour avoir un résultat
            $myArticle = $article->getArticleById(); 

            //Récupérer l'auteur de l'article
            $author = new User($myArticle->getIdUser(), null, null, null, null, null);
            //Création d'un nouvel objet User avec uniquement l'identifiant de l'auteur de l'article, on récupère l'id_user grâce au getter getIdUser() de l'objet $myArticle, les valeurs null correspondent aux autres propriétés de l'objet User qui ne sont pas nécessaires ici
            $myAuthor = $author->getUserById();   

            require_once(__DIR__ . "/../Views/showArticle.view.php");
        } else {
        $this->redirectToRoute('/', 302);
        }
    }   

    // Méthode pour modifier un article par son id
    public function editArticle()
    {
        //Vérifie si le paramètre 'id' existe dans l'URL (méthode GET), le code ici ne s'exécute que si 'id' est présent, exemple d'URL : affichArticle?id=1
        if(isset($_GET['id'])){
            //Récupère la valeur 'id' depuis l'URL ($_GET) puis convertit les caractères spéciaux en entités HTML pour éviter les injections de code HTML/JavaScript (XSS)
            $id = htmlspecialchars($_GET['id']);
            //Création d'un nouvel objet de la classe Article, on appelle le constructeur de la classe avec 4 paramètres (on donne l'id et 3 arguments null)
            $article = new Article($id, null, null, null);
            //on appelle notre méthode getArticleById (qui vient du model article.php) pour avoir un résultat
            $myArticle = $article->getArticleById();
            
            //Vérifie que l'article existe et que l'utilisateur connecté est bien l'auteur de l'article ($_SESSION['user']['id_user'] contient l’ID de l’utilisateur connecté stocké dans la session après connexion, $myArticle->getIdUser() récupère l’ID de l’auteur de l’article)
            if($myArticle && ($_SESSION['user']['id_user'] === $myArticle->getIdUser())){
                //Le code ici s'exécute uniquement si le formulaire a été envoyé avec une méthode POST (et que le champ de formulaire 'editArticle' existe (ici dans un bouton))
                if(isset($_POST['editArticle'])){
                    //Récupère la valeur 'title' (la donnée envoyée par l'utilisateur connecté envoyée via un formulaire (méthode POST) puis convertit les caractères spéciaux en entités HTML pour éviter les injections de code (XSS) lors de l'affichage
                    $title = htmlspecialchars($_POST['title']);
                    //Récupère la valeur 'article' (la donnée envoyée par l'utilisateur connecté envoyée via un formulaire (méthode POST) puis convertit les caractères spéciaux en entités HTML pour éviter les injections de code (XSS) lors de l'affichage
                    $text = htmlspecialchars($_POST['article']);
                    //Contrôle les données avant traitement (avant insertion en base de données en appelant la méthode Chek afin de vérifier que les champs titre et text remplis par l'utilisateur ne sont pas vides, trop court ou avec des données invalides qui ne respectent pas le format regex
                    $this->Check('article', $title, $text);

                    //Si le tableau d'erreur est vide donc que les formats des champs sont bien respectés et non vides
                    if(empty($this->errors)){
                        //Création d'une varibale $updateArticle pour modifier l'article existant, le nouvel objet new Article prend en paramètre 4 arguments dont l'id de l'article qui sert à identifier quel article modifier, nouveau titre saisi par l'utilisateur, nouveau contenu de l'article, id du user est null car c'est un paramètre non utilisé ici
                        $updateArticle = new Article($id, $title, $text, null);
                        //Appelle la méthode editArticle() sur l'objet $updateArticle afin de modifier (UPDATE) l'article en base de données en utilisant les nouvelles données contenues dans l'objet (id, title, text, etc.)
                        $updateArticle->editArticle();
                        $this->redirectToRoute('/affichArticle?id='.$id , 200);
                    }
                }
                //Cette instruction permet de charger et afficher la vue editArticle située dans le dossier Views (require_once permet d'inclure un fichier php qu'une seule fois afin d'éviter les doublons, __DIR__ donne le chemin du dossier actuel du fichier,  /../ remonte d'un dossier pour accéder au dossier Views puis charge le fichier editArticle.view.php)
                require_once(__DIR__ . "/../Views/editArticle.view.php");
            //Si la condition précédente n'est pas remplie (ex : utilisateur non autorisé ou article invalide)
            }else{
                //Redirige l'utilisateur vers la page d'accueil '/', 302 = redirection temporaire (HTTP)
                $this->redirectToRoute('/', 302);
           
            } 
        //Deuxième cas d'échec, utilisateur non connecté ou accès interdit 
        }else{
            //Redirection vers la page d'accueil
            $this->redirectToRoute('/', 302);
        }
        
    }
}


/* Avec htmlspecialchars() le script s'affiche comme du texte pour éviter qu’un utilisateur injecte du code malveillant (une attaque XSS consiste à injecter du code JavaScript malveillant dans une page web)
  En effet, un attaquant peut voler des cookies (sessions), usurper un compte utilisateur, modifier le contenu de la page, rediriger vers un site frauduleux */
// Une regex (ou expression régulière) est un outil qui permet de chercher, vérifier un format (email, mot de passe…) ou manipuler du texte selon un modèle précis
 
