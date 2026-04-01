<?php

namespace App\Models;

use Config\Database;


class Article
{
    //? = si je te donne tu seras un int sinon tu seras null
    private ?int $id_article;
    private ?string $title;
    private ?string $text;
    private ?int $id_user;

    // Méthode magique qui va être appelée (exécutée) automatiquement à chaque fois qu’on va instancier une classe (création d'un objet à partir d'un modèle)
    public function __construct(?int $id_article, ?string $title, ?string $text, int $id_user)
    {
        $this->id_article = $id_article;
        $this->title = $title;
        $this->text = $text;
        $this->id_user= $id_user;
    }
    
    //Méthode pour créer un article
    public function addArticle()
    {
        //connexion à la base de données
        $pdo = Database::getConnection();
        //Requête qui permet d'intégrer de nouveaux enregistrements au sein de la base de données
        $sql = "INSERT INTO `article` (`title`, `text`, `id_user`) VALUES (?,?,?)";
        //On appelle la connection à la base de donnée et on prépare la requête
        $statement = $pdo->prepare($sql);
        //Exécute la requête en retourant les paramètres donnés par l'utilisateur
        return $statement->execute([$this->title, $this->text, $this->id_user]);
    }
    //les get

    //Un getter est une méthode utilisée pour récupérer la valeur d’une propriété privée d’un objet
    public function getIdArticle(): int|string|null
    {
        return $this->id_article;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }
     public function getText(): ?string
    {
        return $this->text;
    }
    public function getIdUser() : int|null|string
    {
        return $this->id_user;
    }

    //Les set

    //Un setter est une méthode utilisée pour modifier la valeur d’une propriété privée d’un objet
    public function setIdArticle (int $id_article): void
    {
        $this->id_article = $id_article;
    }
    public function setTitle (string $title): void
    {
        $this->title = $title;
    }
    public function setText (string $text): void
    {
        $this->text = $text;
    }
    public function setIdUser (int $id_user): void
    {
        $this->id_user = $id_user;
    }


}