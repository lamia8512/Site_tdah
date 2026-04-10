<?php
//Cette instruction permet de charger et afficher la vue head.view.php qu'une seule fois en allant dans le sous-dossier partials qui est situé dans le dossier Views, cette vue affiche l'en-tête de la page
require_once(__DIR__ . "/partials/head.view.php");
?>
<!-- Titre du formulaire (<h1> est une balise HTML de titre principal)-->
<h1>Modification d'un article</h1>
<!--la méthode POST envoie les données (champs de formulaire) du client au serveur-->
<form method="POST">
    <!-- Conteneur principal qui centre et limite la largeur du contenu (la classe "container" est une classe CSS Bootstrap) -->
    <div class="container">
        <!-- Classe Bootstrap qui sert à regrouper un champ de formulaire avec son label -->
        <div class="form-group">
            <!-- L'élément label permet de donner un intitulé à un champ de formulaire -->
            <label for="title" class="form-label">Titre :</label>
            <!-- Cette ligne crée un champ de formulaire qui affiche le titre actuel de l’article (affiche le titre actuel de l’article et permet à l’utilisateur de le modifier en envoyant la nouvelle valeur) -->
            <textarea class="form-control" id="title" name="title" style="height: 100px"><?= $myArticle->getTitle(); ?></textarea>
            <?php
            //s'il existe une erreur dans le titre dans le tableau d'erreur
            if(isset($this->errors['title'])){
                ?>
                    <!-- Dans un éccho php, on affiche l'erreur qu'il y a dans le titre -->
                    <p class="text-danger"><?= $this->errors['title']?></p>
                <?php
            }
            ?>
            <!-- L'élément label permet de donner un intitulé à un champ de formulaire -->
            <label for="article" class="form-label">Texte :</label>
            <!-- Cette ligne crée un champ de formulaire qui affiche le contenu actuel de l’article (affiche le contenu actuel de l’article et permet à l’utilisateur de le modifier en envoyant la nouvelle valeur) -->
            <textarea class="form-control" id="article" name="article" style="height: 100px"><?= $myArticle->getText(); ?></textarea>
            <?php
            //s'il existe une erreur dans le contenu de l'article dans le tableau d'erreur
            if(isset($this->errors['article'])){
                ?>
                    <!-- Dans un éccho php, on affiche l'erreur qu'il y a dans le contenu de l'article -->
                    <p class="text-danger"><?= $this->errors['article']?></p>
                <?php
            }
            ?>
        </div>
         <!-- Création d'un bouton de type sumbit pour envoyer les nouvelles données du formulaire au serveur (name permet de récupérer la méthode editArticle dans ArticleController) -->
        <button type="submit" name="editArticle" class="btn btn-warning mt-5">Modifier !</button>
    </div>
</form>
<?php
//Cette instruction permet de charger et afficher la vue footer.view.php qu'une seule fois en allant dans le sous-dossier partials qui est situé dans le dossier Views, cette vue affiche le pied de page
require_once(__DIR__ . "/partials/footer.view.php");