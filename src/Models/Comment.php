<?php

namespace App\Models;

use PDO;
use Config\Database;

class Comment
{
    // ? = si je te donne tu seras soit un int sinon tu seras null (propriétés) soit string ou vide
    private ?int $id_comment; 
    private ?string $text;
    private ?string $creation_date;
    private ?string $modification_date;
    private ?int $id_article;
    private ?int $id_user;
    private ?string $pseudo;

    // Méthode magique qui va être appelée (exécutée) automatiquement à chaque fois qu’on va instancier une classe (création d'un objet à partir d'un modèle)
    public function __construct(?int $id_comment, ?string $text, ?string $creation_date, ?string $modification_date, ?int $id_article, ?int $id_user, ?string $pseudo)
    {
        $this->id_comment = $id_comment;
        $this->text = $text;
        $this->creation_date = $creation_date;
        $this->modification_date = $modification_date;
        $this->id_article = $id_article;
        $this->id_user = $id_user;
        $this->pseudo = $pseudo;
    }

    // Méthode pour créer un commentaire
    public function addComment()
    {
        // Connexion à la base de données
        $pdo = Database::getConnection();
        // Requête qui permet d'intégrer de nouveaux enregistrements au sein de la base de données
        $sql = "INSERT INTO `comment` (`text`, `creation_date`, `id_article`, `id_user`) VALUES (?,?,?,?)";
        // On appelle la connection à la base de donnée et on prépare la requête
        $stmt = $pdo->prepare($sql);
        // Exécute la requête en retourant les paramètres donnés par l'utilisateur
        return $stmt->execute([$this->text, $this->creation_date, $this->id_article, $this->id_user]);
    }

    // Méthode permettant de récupérer tous les commentaires d’un article
    public function getCommentByArticle()
    {
        // Connexion à la base de données
        $pdo = Database::getConnection();
        // Requête qui permet de sélectionner les informations des commentaires et récupère aussi le pseudo de l'utilisateur grâce à la jointure INNER JOIN avec la table user afin de récupérer tous les commentaires d'un article par leur id-article
        $sql = "SELECT `comment`.`id_comment`, `comment`.`text`, `comment`.`creation_date`, `comment`.`modification_date`, `comment`.`id_article`, `comment`.`id_user`, `user`.`pseudo`
        FROM `comment` 
        INNER JOIN `user` ON `comment`.`id_user` = `user`.`id_user`
        WHERE `id_article` = ?";
        // On appelle la connection à la base de donnée et on prépare la requête (sécurisée contre les injections SQL car qu’elle utilise une requête préparée (prepared statement) avec PDO donc la requête est envoyée sans les données, et PDO va traiter ça comme une simple valeur texte, pas comme du SQL)
        $stmt = $pdo->prepare($sql);
        // Exécute la requête en remplaçant le ? par l'id de l'article courant
        $stmt->execute([$this->id_article]);
        // Récupère tous les résultats sous forme de tableau associatif
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // On créer un tableau vide
        $comments = [];
        // Je boucle sur mon tableau de résultat pour créer un nouvel objet de chaque résultat
        foreach($result as $row){
            // Je créer un nouvel objet
            $comment = new Comment($row['id_comment'], $row['text'], $row['creation_date'], $row['modification_date'], $row['id_article'], $row['id_user'], $row['pseudo']);
            // Je l'insert dans mon tableau
            $comments[] = $comment;
        }
        return $comments;
    }

    public function getIdComment(): ?int
    {
        return $this->id_comment;
    }
    public function getText(): ?string
    {
        return $this->text;
    }
    public function getCreationDate(): ?string
    {
        return $this->creation_date;
    }
    public function getModificationDate(): ?string
    {
        return $this->modification_date;
    }
    public function getIdArticle(): ?int
    {
        return $this->id_article;
    }
    public function getIdUser(): ?int
    {
        return $this->id_user;
    }
      public function getPseudo(): ?string
    {
        return $this->pseudo;
    }


    public function setIdComment(?int $id_comment): void
    {
        $this->id_comment = $id_comment;
    }
    public function setText(?string $text): void
    {
        $this->text = $text;
    }
    public function setCreationDate(?string $creation_date): void
    {
        $this->creation_date = $creation_date;
    }
    public function setModificationDate(?string $modification_date): void
    {
        $this->modification_date = $modification_date;
    }
    public function setIdArticle(?int $id_article): void
    {
        $this->id_article = $id_article;
    }
    public function setIdUser(?int $id_user): void
    {
        $this->id_user = $id_user;
    }
}

/* 
    PDO signifie PHP Data Objects
    C’est une interface (outil) en PHP qui permet de : se connecter à une base de données, exécuter des requêtes SQL, récupérer des données 
    */

/* 
    Une requête SQL est une instruction envoyée à une base de données pour : lire des données, ajouter des données, modifier des données, supprimer des données donc c'est elle permet de faire un CRUD
    1. Lire des données (SELECT) → SELECT * FROM users; Récupère tous les utilisateurs
    2. Ajouter (INSERT) → INSERT INTO users (name) VALUES ('Gabriel'); Ajoute un utilisateur
    3. Modifier (UPDATE) → UPDATE users SET name = 'Joaquin' WHERE id = 1; Modifie un utilisateur
    4. Supprimer (DELETE) → DELETE FROM users WHERE id = 1; Supprime un utilisateur
    CRUD signifie : C Create (Créer) en SQL INSERT, Read (Lire) en SQL SELECT, Update (Modifier) en SQL UPDATE, Delete en SQL DELETE (Supprimer) 
*/ 

/* 
    Un tableau associatif où :
    ➡️ on utilise des clés personnalisées (noms) au lieu de simples numéros
    $user = [
        "name" => "Gabriel",
        "age" => 13,
        "city" => "Paris"
    ];

    ici : 
    "name", "age", "city" = clés 
    "Gabriel", 13, "Paris" = valeurs
*/

/* 
    Important : Pseudo n'existe pas dans ma table `comment` car il n’est pas une colonne de cette table mais de la table `user`, la table `comment` contient seulement id_user
    ➡️ pseudo est une propriété de mon objet PHP (private ?string $pseudo;), pas de la base de données 
    Il vient de la requête SQL :
    SELECT comment.*, user.pseudo
    FROM comment
    INNER JOIN user ON comment.id_user = user.id_user
    
    Donc je récupère pseudo via le JOIN et je le stocke dans mon objet Comment :
    $comment = new Comment(
    $row['id_comment'],
    ...
    $row['pseudo']);

    PHP reçoit pseudo même si la table comment ne l’a pas
*/