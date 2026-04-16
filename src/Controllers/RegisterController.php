<?php 

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\User;

// Création d'une nouvelle classe (RegisterController) qui héritera des propriétés et des méthodes d'une classe parent (AbstractController)
class RegisterController extends AbstractController
{
    // Déclare une méthode publique appelée register pour l'inscription
    public function register ()
    {
        // S'il existe un post dans mon formulaire d'inscription register (lorsque l'utilisateur a envoyé le post)
        if(isset($_POST['register'])){
            // La fonction htmlspecialchars() convertit certains caractères prédéfinis en entités HTML (en chaînes de caractères) pour prévenir les attaques XSS
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);
            
            // On appelle notre méthode Check pour vérifier le format et que notre tableau n'est pas vide (les champs ne doivent pas ête vides ni remplis n'importe comment)
            $this->Check('pseudo', $pseudo);
            $this->Check('email', $email);
            $this->Check('password', $password);

            // var_dump($this->errors);
            if(empty($this->errors)){
                $today = date('Y-m-d');
                // hash le mot de passe :
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $user = new User(null, $pseudo, $email, $passwordHash, $today, 2);
                $ifExist = $user->getUserByEmail();
                
                 // Si l'email du user existe dans la base de données alors :
                if($ifExist){
                    // On envoie vers connection (on appel la fonction errorMessage)
                    var_dump("Un compte avec cette boite mail existe déjà !");
                }else{
                    // On appelle la méthode pour l'enregistrer dans la base de données
                    $user->register();
                }
                
            }
        }
    require_once(__DIR__ . "/../Views/register.view.php");
    }            
}
            