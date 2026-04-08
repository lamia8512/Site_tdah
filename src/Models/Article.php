<?php

namespace App\Models;
use PDO;
use Config\Database;


class Article
{
    //? = si je te donne tu seras un int sinon tu seras null (propriétés)
    private ?int $id_article; //? soit string ou vide
    private ?string $title;
    private ?string $text;
    private ?int $id_user;

    //Méthode magique qui va être appelée (exécutée) automatiquement à chaque fois qu’on va instancier une classe (création d'un objet à partir d'un modèle)
    public function __construct(?int $id_article, ?string $title, ?string $text, ?int $id_user)
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

    //Méthode pour récupérer tous les articles
     public function getAllArticles()
    {
        //connexion à la base de données
        $pdo = Database::getConnection();
        //On sélectionne les colonnes (propriétés) de la table article + le pseudo de l'utilisateur (auteur), INNER JOIN permet de relier chaque article à son auteur via la clé étrangère article.id_user = user.id_user
        $sql = "SELECT `article`.`id_article`, `article`.`title`, `article`.`text`, `article`.`id_user`, `user`.`pseudo` 
        FROM `article`
        INNER JOIN `user` ON `article`.`id_user` = `user`.`id_user`";
        //On prépare la requête SQL
        $stmt = $pdo->prepare($sql);
        //On exécute la requête sur la base de données
        $stmt->execute();
        //On récupère tous les résultats sous forme de tableau associatif
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // pour récupérer tous les articles


        //On créer un tableau vide
        $articles = [];
        //Je boucle sur mon tableau de résultat pour créer un nouvel objet de chaque résultat
        foreach($result as $row){
            //Je créer un nouvel objet
            $article = new Article($row['id_article'], $row['title'], $row['text'], $row['id_user']);
            //Je l'insert dans mon tableau
            $articles[] = $article;
        }
        return $articles;
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

    //une fonction est un script qui s'exécute au moment où on l'appelle
}