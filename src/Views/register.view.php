<?php
require_once(__DIR__ . "/partials/head.view.php");
?>
<h1>Inscription</h1>
<!-- La méthode POST envoie les données (champs de formulaire) du client au serveur -->
<form method="POST">
    <div class="container">
        <div class="form-group">
            <!-- L'élément label permet de donner un intitulé à un champ de formulaire -->
            <label for="pseudo" class="form-label">Pseudo :</label>
            <!-- L’élément HTML input est un élément qui va permettre à l’utilisateur d’envoyer des données. Il se présente sous la forme d’une balise orpheline et va obligatoirement posséder un attribut type auquel on va pouvoir donner de nombreuses valeurs -->
            <input type="text" name="pseudo" id="pseudo" placeholder="Lulu" class="form-control">
            <?php 
            // S'il existe une erreur sur le pseudo alors on affiche le message qui se trouve dans la clé erreur "pseudo"
            if(isset($this->errors['pseudo'])){
                ?>
                    <p class="text-danger"><?= $this->errors['pseudo']?></p>
                <?php
            }
            ?>
        </div>
        <div class="form-group">
            <label for="email" class="form-label">Email :</label>
            <input type="email" name="email" id="email" placeholder="Lulu@gmail.com" class="form-control">
            <?php 
            // S'il existe une erreur sur le mail alors on affiche le message qui se trouve dans la clé erreur "email"
            if(isset($this->errors['email'])){
                ?>
                    <p class="text-danger"><?= $this->errors['email']?></p>
                <?php
            }
            ?>
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Mot de passe :</label>
            <input type="password" name="password" id="password" class="form-control">
            <?php
            // S'il existe une erreur sur le mot de passe alors on affiche le message qui se trouve dans la clé erreur "password"
            if(isset($this->errors['password'])){
                ?>
                    <p class="text-danger"><?= $this->errors['password']?></p>
                <?php
            }
            ?>
        </div>
        <!-- Création d'un bouton de type sumbit pour envoyer les données du formulaire au serveur (name permet de récupérer la méthode register dans RegisterConntroller -->
        <button type="submit" name="register" class="btn btn-primary mt-5">Inscription</button>
    </div>
</form>
<?php
require_once(__DIR__ . "/partials/footer.view.php");