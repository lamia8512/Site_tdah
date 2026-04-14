<?php
require_once(__DIR__ . "/partials/head.view.php");
?>
<h1>Création d'un article</h1>
<!-- La méthode POST envoie les données (champs de formulaire) du client au serveur -->
<form method="POST">
    <div class="container">
        <div class="form-group">
            <!-- L'élément label permet de donner un intitulé à un champ de formulaire -->
            <label for="title" class="form-label">Post un titre !</label>
            <!-- L’élément HTML input est un élément qui va permettre à l’utilisateur d’envoyer des données. Il se présente sous la forme d’une balise orpheline et va obligatoirement posséder un attribut type auquel on va pouvoir donner de nombreuses valeurs -->
            <textarea class="form-control" id="title" name="title" style="height: 100px"></textarea>
            <?php 
           // S'il existe une erreur dans le titre dans le tableau d'erreur
            if(isset($this->arrayError['title'])){
                ?>
                    <!-- Dans un éccho php, on affiche l'erreur qu'il y a dans le titre -->
                    <p class="text-danger"><?= $this->arrayError['title']?></p>
                <?php
            }
            ?>
            <!-- L'élément label permet de donner un intitulé à un champ de formulaire -->
            <label for="article" class="form-label">Post un article !</label>
            <!-- L’élément HTML input est un élément qui va permettre à l’utilisateur d’envoyer des données. Il se présente sous la forme d’une balise orpheline et va obligatoirement posséder un attribut type auquel on va pouvoir donner de nombreuses valeurs -->
            <textarea class="form-control" id="article" name="article" style="height: 100px"></textarea>
            <?php 
           // S'il existe une erreur dans l'article dans le tableau d'erreur
            if(isset($this->arrayError['article'])){
                ?>
                    <!-- Dans un éccho php, on affiche l'erreur qu'il y a dans l'article -->
                    <p class="text-danger"><?= $this->arrayError['article']?></p>
                <?php
            }
            ?>
        </div>
        <!-- Création d'un bouton de type sumbit pour envoyer les données du formulaire au serveur (name permet de récupérer la méthode addArticle dans ArticleController -->
        <button type="submit" name="addArticle" class="btn btn-success mt-5">Poster !</button>
    </div>
</form>
<?php
require_once(__DIR__ . "/partials/footer.view.php");