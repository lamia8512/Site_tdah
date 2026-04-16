<?php
require_once(__DIR__ . "/partials/head.view.php");
?>
<!-- Titre du formulaire (<h1> est une balise HTML de titre principal)-->
<h1>Modifier votre commentaire</h1>
<!-- La méthode POST envoie les données (champs de formulaire) du client au serveur -->
 <form method="POST">
    <!-- Conteneur principal qui centre et limite la largeur du contenu (la classe "container" est une classe CSS Bootstrap) -->
    <div class="container">
        <!-- Classe Bootstrap qui sert à regrouper un champ de formulaire avec son label -->
        <div class="form-group">
            <!-- L'élément label permet de donner un intitulé à un champ de formulaire -->
            <label for="comment" class="form-label">Vous pouvez modifier votre commentaire : </label>
             <!-- Cette ligne crée un champ de formulaire qui affiche le contenu actuel du commentaire et permet à l’utilisateur de le modifier en envoyant la nouvelle valeur -->
            <textarea class="form-control" id="comment" name="comment" style="height: 100px"><?= $myComment->getText(); ?></textarea>
            <?php
            // S'il existe une erreur dans le contenu du commentaire dans le tableau d'erreur
            if(isset($this->errors['comment'])){
                ?>
                <!-- Dans un éccho php, on affiche l'erreur qu'il y a dans le contenu du commentaire en rouge -->
                <p class="text-danger"><?= $this->errors['comment']?></p>
                <?php
            }
            ?>
        </div>
        <!-- Création d'un bouton jaune de type sumbit pour envoyer les nouvelles données du formulaire au serveur (name permet de récupérer la méthode editComment dans CommentController) -->
        <button type="submit" name="editComment" class="btn btn-warning">Modifier !</button>
    </div>
</form>
<?php
require_once(__DIR__ . "/partials/footer.view.php");
?>