<?php
require_once(__DIR__ . "/partials/head.view.php");
?>
<h1>Connexion</h1>
<!--la méthode POST envoie les données (champs de formulaire) du client au serveur-->
<form method="POST">
    <div class="container">
        <div class="form-group">
            <!--l'élément label permet de donner un intitulé à un champ de formulaire-->
            <label for="email" class="form-label">Donne moi ton email :</label>
            <!--l’élément HTML input est un élément qui va permettre à l’utilisateur d’envoyer des données. Il se présente sous la forme d’une balise orpheline et va obligatoirement posséder un attribut type auquel on va pouvoir donner de nombreuses valeurs-->
            <input type="email" name="email" id="email" placeholder="Lulu@gmail.com" class="form-control">
            <?php 
            //s'il existe une erreur sur le mail dans le tableau d'erreur
            if(isset($this->errors['email'])){
                ?>
                    <!--dans un éccho php, on affiche l'erreur qu'il y a dans l'email-->
                    <p class="text-danger"><?= $this->errors['email']?></p>
                <?php
            }
            ?>
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Donne moi ton mot de pase :</label>
            <input type="password" name="password" id="password" class="form-control">
            <?php
            //s'il existe une erreur sur le mot de passe dans le tableau d'erreur
            if(isset($this->errors['password'])){
                ?>
                    <!--dans un éccho php, on affiche l'erreur qu'il y a dans le password-->
                    <p class="text-danger"><?= $this->errors['password']?></p>
                <?php
            }
            ?>
        </div>
        <!--création d'un bouton de type sumbit pour envoyer les données du formulaire au serveur (name permet de récupérer la méthode login dans dans SessionConntroller-->
        <button type="submit" name="login" class="btn btn-warning mt-5">Connexion</button>
    </div>
</form>
<?php
require_once(__DIR__ . "/partials/footer.view.php");
?>