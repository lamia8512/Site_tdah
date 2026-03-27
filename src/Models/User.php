<?php

namespace App\Models;

use PDO;
use Config\Database;


class User
{
    //? = si je te donne tu seras un int sinon tu seras null
    private ?int $id_user;
    private ?string $pseudo;
    private ?string $email;
    private ?string $password;
    private ?string $creation_date;
    private ?int $id_role;

    public function __construct(?int $id_user, ?string $pseudo, ?string $email, ?string $password, ?string $creation_date, ?int $id_role)
    {
        $this->id_user = $id_user;
        $this->pseudo = $pseudo;
        $this->email = $email;
        $this->password = $password;
        $this->creation_date = $creation_date;
        $this->id_role = $id_role;
    }

    public function register()
    {
        $pdo = Database::getConnection();
        $sql = "INSERT INTO `user` (`pseudo`, `email`, `password`, `creation_date`, `id_role`) VALUES (?,?,?,?,?)";
        $statement = $pdo->prepare($sql);
        return $statement->execute([$this->pseudo, $this->email, $this->password, $this->creation_date, $this->id_role]);
    }

    public function getUserByEmail()
    {
        $pdo = Database::getConnection();
        $sql = "SELECT `id_user`, `pseudo`, `email`, `password`, `creation_date`, `id_role` FROM `user` WHERE `email` = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$this->email]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result){
            return new User($result['id_user'], $result['pseudo'], $result['email'], $result['password'], $result['creation_date'], $result['id_role']);
        }else{
            return false;
        }
    }

    //les get

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

    //Les set
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