<?php

namespace App\Models;

use PDO;
use Config\Database;


class User
{
    // ? = si je te donne tu seras soit un int sinon tu seras null (propriétés) soit string ou vide
    private ?int $id_user;
    private ?string $pseudo;
    private ?string $email;
    private ?string $password;
    private ?string $creation_date;
    private ?int $id_role;

    // Méthode magique qui va être appelée (exécutée) automatiquement à chaque fois qu’on va instancier une classe (création d'un objet à partir d'un modèle)
    public function __construct(?int $id_user, ?string $pseudo, ?string $email, ?string $password, ?string $creation_date, ?int $id_role)
    {
        $this->id_user = $id_user;
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->password = $password;
        $this->creation_date = $creation_date;
        $this->id_role = $id_role;
    }
    
    // Méthode pour récupérer des données de l'utilisateur pour la création du formulaire d'inscription
    public function register()
    {
        // Connexion à la base de données
        $pdo = Database::getConnection();
        // Requête qui permet d'intégrer de nouveaux enregistrements au sein de la base de données
        $sql = "INSERT INTO `user` (`pseudo`, `email`, `password`, `creation_date`, `id_role`) VALUES (?,?,?,?,?)";
        // On appelle la connection à la base de donnée et on prépare la requête
        $statement = $pdo->prepare($sql);
        // Exécute la requête en retourant les paramètres donnés par l'utilisateur
        return $statement->execute([$this->pseudo, $this->email, $this->password, $this->creation_date, $this->id_role]);
    }

    // Méthode pour récupérer un user par son email
    public function getUserByEmail()
    {
        // Je fais une requête sql pour récupérer le user par son email
        $pdo = Database::getConnection();
        $sql = "SELECT `id_user`, `pseudo`, `email`, `password`, `creation_date`, `id_role` FROM `user` WHERE `email` = ?";
        // On appelle la connection à la base de donnée et on prépare la requête
        $statement = $pdo->prepare($sql);
        // On exécute la requête en donnant l'email comme paramètre
        $statement->execute([$this->email]);
        // Je mets la réponse de la requête dans la variable result
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        // S'il existe un user, alors affiche-moi tous ses paramètres :
        if($result){
            return new User($result['id_user'], $result['pseudo'], $result['email'], $result['password'], $result['creation_date'], $result['id_role']);
        }else{
            // Sinon retourne faux
            return false;
        }
    }

    // Méthode pour récupérer un user par son id
     public function getUserById()
    {
        // Je fais une requête sql pour récupérer le user par son id
        $pdo = Database::getConnection();
        $sql = "SELECT `id_user`, `pseudo`, `id_role` FROM `user` WHERE `id_user` = ?";
        // On appelle la connection à la base de donnée et on prépare la requête
        $statement = $pdo->prepare($sql);
        // On exécute la requête en donnant l'id comme paramètre
        $statement->execute([$this->id_user]);
        // S'il existe un user, alors affiche-moi tous ses paramètres :
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result){
            return new User($result['id_user'], $result['pseudo'], null, null, null, $result['id_role']);
        }else{
            // Sinon retourne faux
            return false;
        }
    }

     /* 
    * Les get
    * Un getter est une méthode utilisée pour récupérer la valeur d’une propriété privée d’un objet
    */

    public function getIdUser(): int|string|null
    {
        return $this->id_user;
    }
    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }
     public function getEmail(): ?string
    {
        return $this->email;
    }
    public function getPassword(): ?string
    {
        return $this->password;
    }
    public function getCreationDate() : ?string
    {
        return $this->creation_date;
    }
    public function getIdRole() : int|null|string
    {
        return $this->id_role;
    }

     /* 
    * Les set
    * Un setter est une méthode utilisée pour modifier la valeur d’une propriété privée d’un objet
    */
     
    public function setIdUser (int $id_user): void
    {
        $this->id_user = $id_user;
    }
    public function setPseudo (string $pseudo): void
    {
        $this->pseudo = $pseudo;
    }
    public function setEmail (string $email): void
    {
        $this->email = $email;
    }
    public function setPassword (string $password): void
    {
        $this->password = $password;
    }
    public function setCreationDate (string $creation_date): void
    {
        $this->creation_date = $creation_date;
    }
    public function setIdRole (int $id_role): void
    {
        $this->id_role = $id_role;
    }


}