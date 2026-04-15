<?php

namespace App\Models;
use PDO;
use Config\Database;


class Article
{
    // ? = si je te donne tu sera soit un int sinon tu seras null (propriétés) soit string ou vide
    private ?int $id_article; 
    private ?string $title;
    private ?string $text;
    private ?int $id_user;

    // Méthode magique qui va être appelée (exécutée) automatiquement à chaque fois qu’on va instancier une classe (création d'un objet à partir d'un modèle)
    public function __construct(?int $id_article, ?string $title, ?string $text, ?int $id_user)
    {
        $this->id_article = $id_article;
        $this->title = $title;
        $this->text = $text;
        $this->id_user= $id_user;
    }
    
    // Méthode pour créer un article
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

    // Méthode pour récupérer tous les articles
     public function getAllArticles()
    {
        // Connexion à la base de données
        $pdo = Database::getConnection();
        // On sélectionne les colonnes (propriétés) de la table article + le pseudo de l'utilisateur (auteur), INNER JOIN permet de relier chaque article à son auteur via la clé étrangère article.id_user = user.id_user
        $sql = "SELECT `article`.`id_article`, `article`.`title`, `article`.`text`, `article`.`id_user`, `user`.`pseudo` 
        FROM `article`
        INNER JOIN `user` ON `article`.`id_user` = `user`.`id_user`";
        // On prépare la requête SQL
        $stmt = $pdo->prepare($sql);
        // On exécute la requête sur la base de données
        $stmt->execute();
        // On récupère tous les résultats sous forme de tableau associatif
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC); // pour récupérer tous les articles


        // On créer un tableau vide
        $articles = [];
        // Je boucle sur mon tableau de résultat pour créer un nouvel objet de chaque résultat
        foreach($result as $row){
            // Je créer un nouvel objet
            $article = new Article($row['id_article'], $row['title'], $row['text'], $row['id_user']);
            // Je l'insert dans mon tableau
            $articles[] = $article;
        }
        return $articles;
    }

    // Méthode pour récupérer un article par son id
     public function getArticleById()
    {
        // Connexion à la base de données
        $pdo = Database::getConnection();
        // On sélectionne les colonnes (propriétés) de la table article et on filtre les résultats pour ne retourner qu'un seul article
        $sql = "SELECT `id_article`, `title`, `text`, `id_user` 
        FROM `article` WHERE `id_article`= ?";
        // On prépare la requête SQL
        $stmt = $pdo->prepare($sql);
        // On exécute la requête, en remplaçant le marqueur `?` de la requête par la valeur de $this->id_article ()
        $stmt->execute([$this->id_article]);
        // On récupère le résultat de chaque article sous forme de tableau associatif
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // Vérifie si la requête a retourné un résultat
        if($result){
            // Si oui, on crée et retourne un nouvel objet Article en passant les valeurs récupérées depuis la base de données
            return new Article($result['id_article'], $result['title'], $result['text'], $result['id_user']);
        }else{
            // Si aucun article n'est trouvé, on retourne false
            return false;
        }

    }

    // Méthode pour modifier un article 
     public function editArticle()
    {
        // Connexion à la base de données
        $pdo = Database::getConnection();
        // Requête qui permet de modifier les données stockées dans la base de données par les nouvelles données envoyées par l'utilisateur qui a crée l'article
        $sql = "UPDATE `article` SET `title` = ?, `text` = ? WHERE `id_article` = ?";
        // On prépare la requête SQL
        $stmt = $pdo->prepare($sql);
        // Exécute la requête en retourant les paramètres donnés par l'utilisateur
        return $stmt->execute([$this->title, $this->text, $this->id_article]);
    }

     // Méthode pour supprimer un article
    public function deleteArticle()
    {
        // Connexion à la base de données
        $pdo = Database::getConnection();
        // Requête qui permet de supprimer un article (stocké dans la base de données dans la table article) lorsqu'il y a un id en paramètre et filtre sur l'identifiant de l'article pour éviter de supprimer tous les articles de la table
        $sql = "DELETE FROM `article` WHERE `id_article` = ?";
        // On prépare la requête SQL
        $stmt = $pdo->prepare($sql);
        // On exécute la requête, en remplaçant le marqueur `?` de la requête par la valeur de $this->id_article ()
        return $stmt->execute([$this->id_article]);
    }

    // Les get

    // Un getter est une méthode utilisée pour récupérer la valeur d’une propriété privée d’un objet
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

    // Les set

    // Un setter est une méthode utilisée pour modifier la valeur d’une propriété privée d’un objet
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

    // Une fonction est un script qui s'exécute au moment où on l'appelle
}