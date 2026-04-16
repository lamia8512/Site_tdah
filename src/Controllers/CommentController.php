<?php

//Déclare le namespace de ce fichier : en PHP, c’est un espace de noms qui sert à organiser le code et éviter les conflits
namespace App\Controllers;

// Importe la classe Comment depuis le namespace App\Models
use App\Models\Comment;
// Importe la classe AbstractController depuis le namespace App\Utils (Un AbstractController est une classe de base (classe mère) dont héritent les contrôleurs (qui fournit des outils communs à tous les contrôleurs) pour éviter de répéter du code)
use App\Utils\AbstractController;

// Déclare la classe CommentController qui hérite de AbstractController (extends = héritage en PH), donc la classe enfant récupère les fonctionnalités de la classe mère
class CommentController extends AbstractController
{
    // Méthode pour modifier un commentaire
    public function editComment()
    {
        // Vérifie si le paramètre 'id' existe dans l'URL (méthode GET), le code ici ne s'exécute que si 'id' est présent, exemple d'URL : affichArticle?id=10
        if(isset($_GET['id'])){
            // Récupère la valeur 'id' depuis l'URL ($_GET) puis convertit les caractères spéciaux en entités HTML pour éviter les injections de code HTML/JavaScript (XSS)
            $id = htmlspecialchars($_GET['id'] );
            
            // Je dois instancier l'objet Comment pour pouvoir utiliser la méthode getCommentById (on donne l'id et 6 arguments null)
            $comment = new Comment($id, null, null, null, null, null, null);
            // Appelle la méthode getCommentById (qui vient du model Comment.php) et stocke le résultat dans la variable $myComment
            $myComment = $comment->getCommentById();

            /*
            * si j'ai bien un commentaire dans la base de données avec cet id
            * si j'ai bien unse session avec user (donc si une personne est connectée)
            * si id_user et === à l'id du user qui a créer le commentaire
            */
            if($myComment && $_SESSION['user'] && $_SESSION['user']['id_user'] === $myComment->getIdUser()){
                // Le code ici s'exécute uniquement si le formulaire a été envoyé avec une méthode POST (et que le champ de formulaire 'editComment' existe (ici dans un bouton))
                if(isset($_POST['editComment'])){
                    // Récupère la valeur 'comment'(la donnée envoyée par l'utilisateur connecté envoyée via un formulaire (méthode POST) puis convertit les caractères spéciaux en entités HTML pour éviter les injections de code (XSS) lors de l'affichage
                    $comment = htmlspecialchars($_POST['comment']);
                    // Contrôle les données avant traitement (avant insertion en base de données en appelant la méthode Chek afin de vérifier que les champs titre et text remplis par l'utilisateur ne sont pas vides, trop court ou avec des données invalides qui ne respectent pas le format regex
                    $this->Check('comment', $comment);

                    // Si le tableau d'erreur est vide donc que les formats des champs sont bien respectés et non vides
                    if(empty($this->errors)){
                        // Récupère la date actuelle au format "année-mois-jour"
                        $today = date("Y-m-d");
                        // Crée un nouvel objet Comment avec les données nécessaires à la modification ( ID du commentaire à modifier, nouveau texte du commentaire, date de création (inchangée ici), nouvelle date de modification (aujourd'hui), ID de l'article lié au commentaire, ID de l'utilisateur (auteur du commentaire), pseudo (non nécessaire ici, récupéré via JOIN))
                        $newComment = new Comment($id, $comment, null, $today, $myComment->getIdArticle(), $myComment->getIdUser(), null);
                        // Appelle la méthode editComment() sur l'objet $newComment, cette méthode exécute la requête SQL de mise à jour (UPDATE) pour modifier le commentaire en base de données avec les nouvelles valeurs
                        $newComment->editComment();
                        // Redirige l'utilisateur vers la page d'affichage de l'article après la modification du commentaire 
                        $this->redirectToRoute('/affichArticle?id=' . $myComment->getIdArticle() , 200);
                    }
                }

                require_once(__DIR__ . "/../Views/editComment.view.php");
            }else{
                $this->RedirectToRoute('/', 302);
            }  
        }else{
            $this->RedirectToRoute('/', 302);
        }
        
    }

    //Méthode pour supprimer un commentaire
    public function deleteComment()
    {
        // Vérifie si une donnée 'id' a été envoyée via un formulaire (méthode POST)
        if(isset($_POST['id'])){
            // Récupère la valeur 'id' envoyée via POST (formulaire) puis convertit les caractères spéciaux en entités HTML pour éviter les injections de code HTML/JavaScript (XSS)
            $id = htmlspecialchars($_POST['id']);
            // Création d'un nouvel objet de la classe Comment, on appelle le constructeur de la classe avec 7 paramètres (on donne l'id et 6 arguments null car on a seulement besoin de l'id du commentaire, les champs null sont soit pas encore chargés ou inutiles)
            $comment = new Comment($id, null, null, null, null, null, null);
            // Appelle la méthode getCommentById() sur l'objet $comment, cette méthode va chercher en base de données le commentaire correspondant à l'ID contenu dans $comment et retourne le résultat (souvent un objet Comment ou null si non trouvé)
            $myComment = $comment->getCommentById();

            // // Vérifie plusieurs conditions pour autoriser une action, cas 1 : l'utilisateur est connecté ET est l'auteur du commentaire ou cas 2 : l'utilisateur est connecté ET est administrateur (role = 1 donc admin)
            if(($myComment && $_SESSION['user']['id_user'] === $myComment->getIdUser()) || ($myComment && $_SESSION['user']['id_role'] === 1)){
                // Supprime le commentaire de la base de données en appelant la méthode deleteComment
                $myComment->deleteComment();
                // Redirige l'utilisateur vers la page d'affichage de l'article après suppression
                $this->redirectToRoute('/affichArticle?id=' . $myComment->getIdArticle() , 200);
           
            }else{
                // Si l'utilisateur n'est pas autorisé → redirection
                $this->redirectToRoute('/', 302);
            }
        }else{
            // Si aucun ID n'est fourni → erreur 404 (page non trouvée)
            $this->redirectToRoute('/404', 404);
        }
    }
}

/* 
* admin a un rôle 1 car c'est un standard dans les applications
* Beaucoup de systèmes utilisent : 
* id_role → rôle → pouvoirs
* 0 ou 1 → admin → tout gérer (site + utilisateurs + rôles)
* 2 → user → écrire, commenter
* 3 → moderator → gérer et surveiller le contenu
*/