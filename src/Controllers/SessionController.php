<?php

namespace App\Controllers;

use App\Models\User;
use App\Utils\AbstractController;

//création d'une nouvelle classe (SessionController) qui héritera des propriétés et des méthodes d'une classe parent (AbstractController)
class SessionController extends AbstractController
{
    // création de la méthode connexion
    public function login ()
    {
        //s'il existe un post dans login
        if(isset($_POST['login'])){
            //les valeurs données par l'utilisateur seront lues comme chaînes de caractères et non comme du script
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            //on appelle notre méthode Check pour vérifier le format et que notre tableau n'est pas vide (les champs ne doivent pas ête vides ni remplis n'importe comment)
            $this->Check('email', $email);
            $this->Check('password', $password);

            //si mon tableau d'erreur est vide 
            if(!$this->errors){
                //création d'une variable user pour instancier mon objet user en lui donnant des valeurs (ce sont les champs email et password du formulaire de connexion)
                $user = new User(null, null, $email, $password,null, null);
                //création d'une nouvelle variable myUser qui va appeler la méthode getUserById (qui va mettre la réponse dans la variable myUser)
                $myUser = $user->getUserByEmail();
                
                //si myUser existe dans la base de données 
                if($myUser){
                    //création d'une variable qui nous permet de vérifier le mot de passe donné par l'utilisateur par rapport à celui stocké dans la base de données
                    $verifPassword = password_verify($password, $myUser->getPassword());

                    // si le mot de passe est correct
                    if($verifPassword){
                        //on sauvegarde dans la superglobale Session (en clé on fait un tableau user)
                        $_SESSION['user'] = [
                            //tableau associatif (stock des données ci-dessous tant que l'utilisateur a son ordinateur allumé sur la page web)
                            'id' => uniqid(), //id unique 
                            'email' => $myUser->getEmail(),
                            'pseudo' => $myUser->getPseudo(),
                            'id_role' => $myUser->getIdRole(),
                            'id_user' => $myUser->getIdUser()
                        ];
                        //301 sont des redirections permanentes de pages web et sont utilisées pour éviter les erreurs 404
                        $this->redirectToRoute('/', 301);
                        //si le mot de passe est incorrect, on va afficher le message d'erreur ci-dessous (pour des raisons de sécurité, il ne faut pas préciser si c'est le mot de passe ou l'email qui est incorret )
                    }else{
                        $this->errorMessage('Ton adresse email ou mot de passe n\'est pas correcte');
                    }
                    //si mon utilisateur myUser n'existe pas, on va alors mettre un messsage d'erreur
                }else{
                    $this->errorMessage('Ton adresse email ou mot de passe n\'est pas correcte');
                }
            }
        }
        require_once(__DIR__ . '/../Views/login.view.php');
    }
    //création de la méthode déconnexion
    public function logout()
    {
        //session détruite (session terminée)
        session_destroy();
        //redirection vers la page index donc la page d'accueil du site, le code 200 indique que la requête a été traité avec succès
        $this->redirectToRoute('/', 200);
    }
}