<?php

namespace App\Controllers;

use App\Models\User;
use App\Utils\AbstractController;

class SessionController extends AbstractController
{
    public function login ()
    {
        if(isset($_POST['login'])){
            $email = htmlspecialchars($_POST['email']);
            $password = htmlspecialchars($_POST['password']);

            $this->Check('email', $email);
            $this->Check('password', $password);

            if(!$this->errors){
                $user = new User(null, null, $email, $password,null, null);
                $myUser = $user->getUserByEmail();

                if($myUser){
                    $verifPassword = password_verify($password, $myUser->getPassword());

                    if($verifPassword){
                        
                        $_SESSION['user'] = [
                            'id' => uniqid(),
                            'email' => $myUser->getEmail(),
                            'pseudo' => $myUser->getPseudo(),
                            'id_role' => $myUser->getIdRole(),
                            'id_user' => $myUser->getIdUser()
                        ];

                        $this->redirectToRoute('/', 301);

                    }else{
                        $this->errorMessage('Ton adresse email ou mot de passe n\'est pas correcte');
                    }

                }else{
                    $this->errorMessage('Ton adresse email ou mot de passe n\'est pas correcte');
                }
            }
        }
        require_once(__DIR__ . '/../Views/login.view.php');
    }

    public function logout()
    {
        session_destroy();
        $this->redirectToRoute('/', 200);
    }
}