<?php 

namespace App\Controllers;

use App\Utils\AbstractController;
use App\Models\User;

class RegisterController extends AbstractController
{
    public function register ()
    {
        if(isset($_POST['register'])){
            $pseudo = htmlspecialchars($_POST['pseudo']);
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $this->Check('pseudo', $pseudo);
            $this->Check('email', $email);
            $this->Check('password', $password);

                     //var_dump($this->errors);
            if(empty($this->errors)){
                $today = date('Y-m-d');
                //Hash le mot de passe :
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $user = new User(null, $pseudo, $email, $passwordHash, $today, 2);
                $ifExist = $user->getUserByEmail();

                if($ifExist){
                    //on envoie vers connection
                    var_dump("Un compte avec cette boite mail existe déjà !");
                }else{
                    //On appelle la méthode pour l'enregistrer dans la base de données
                    $user->register();
                }
                
            }
        }
    require_once(__DIR__ . "/../Views/register.view.php");
    }            
}
            