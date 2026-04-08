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
        if (isset($_SESSION['user'])){
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

            require_once(__DIR__ . "/../Views/article.view.php");
        } else {
        $this->redirectToRoute('/', 302);
        }
    }
}
