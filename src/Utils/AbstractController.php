<?php

namespace App\Utils;

abstract class AbstractController
{
    protected $errors = [];

    public function isNotEmpty ($nameInput)
    {
        //si le post avec la valeur est vide alors
        if(empty($_POST[$nameInput])){
            //On rapelle le tableau et on lui donne en clé le nom de la $value et en valeur une string
            $this->errors[$nameInput] = "Ce champs ne peut pas être vide !";
            //On retour le tableau
            return $this->errors;
        }
        //sinon on retourne false
        return false;
    }

     public function checkFormat($nameInput, $valueInput){

        //Vos regex = vos filtres
        $regexPseudo = "/^([0-9a-z_\-.A-Zà-üÀ-Ü\ ]){3,255}$/";
        $regexPassword = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/";

        //on prend le nom de l'input
        switch($nameInput){

            //Si l'input s'appelle pseudo alors 
            case 'pseudo':

                //si la valeur de l'input n'arrive pas a passer le filtre alors
                if(!preg_match($regexPseudo, $valueInput)){
                    //on appel notre tableau et on ajoute en clé pseudo et en valeur la string
                    $this->errors[$nameInput] = "Merci de renseigner un pseudo correct !";
                }
                break;
            case 'email':

                if(!filter_var($valueInput, FILTER_VALIDATE_EMAIL)){
                    $this->errors[$nameInput] = "Merci de renseigner un e-mail correct !";
                }
                break;

                
            case 'password':

                if(!preg_match($regexPassword, $valueInput)){
                    $this->errors[$nameInput] = "Merci de donner un mot de passe avec au minimum : 8 caractères, 1 majuscule, 1 miniscule, 1 caractère spécial !";
                }
                break;
        }
    }

     //Méthode qui permet d'appeler les deux autres méthodes
    public function Check($nameInput, $valueInput)
    {
        //appelle la méthode checkformat et je lui donne le nom et la valeur de mon input
        $this->checkFormat($nameInput, $valueInput);
        //appelle la méthode isNotEmpty et je lui donne le nom de mon input
        $this->isNotEmpty($nameInput);
        //retourne mon tableau d'erreur:
        return $this->errors;
    }

     public function errorMessage($myMessage){
        ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $myMessage ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
    }

    public function debug ($info){
        echo '<pre>';
        var_dump($info);
        echo '</pre>';
    }

    public function redirectToRoute($route, $code){
        http_response_code($code);
        header("Location: {$route}");
        exit;
    }

}

