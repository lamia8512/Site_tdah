<?php
require_once(__DIR__ . "/partials/head.view.php");
?>
<!-- Conteneur principal qui centre et limite la largeur du contenu (la classe "container" est une classe CSS Bootstrap) -->
<div class="container">
    <!-- Carte Bootstrap centrée avec un fond vert et une marge verticale -->
    <div class="card text-center text-bg-success my-2">
        <!-- En-tête de la carte Bootstrap -->
        <div class="card-header">
            <!-- Affiche le pseudo de l'auteur de l'article dans un paragraphe s'il existe, sinon elle n'affiche rien (l'opérateur ternaire ? et : dans cette ligne est un raccourci du if/else en une seule ligne) -->
            <p><?= $myAuthor ? $myAuthor->getPseudo() : '' ?></p>
        </div>
        <!-- Corps de la carte Bootstrap -->
        <div class="card-body">
            <!-- Affiche le titre de l'article dans un paragraphe HTML (balise p), on appelle la méthode getTitle (dans un écho en php avec la syntaxe guillemet ouvert point d'interrogation, point d'interrogation guillemet fermé) qui retourne le titre de l'article -->
            <p><?= $myArticle->getTitle(); ?></p>
        </div>
        <!-- Corps de la carte Bootstrap -->
        <div class="card-body">
             <!-- Affiche le titre de l'article dans un paragraphe HTML (balise p), on appelle la méthode getText (dans un écho en php avec la syntaxe guillemet ouvert point d'interrogation, point d'interrogation guillemet fermé) qui retourne le texte contenu dans l'article -->
            <p><?= $myArticle->getText(); ?></p>
        </div>
    </div>

    <?php
            //Vérifie deux conditions: la 1re est que l'utilisateur est bien connecté donc que la session user existe, et la 2e que l'utilisateur connecté est l'auteur de l'article
            if(isset($_SESSION['user']) && $_SESSION['user']['id_user'] === $myArticle->getIdUser()){
    ?>
            <!-- Lien permettant d'accéder à la page de modification de l'article (<a href="..."> balise HTML de lien permet de naviguer vers une autre page, ici vers la page de modification avec un paramètre get id, avec la méthode getIdUser on récupére l'id de l'utilisateur (auteur) qui a crée l'article, on crée un bouton de couleur jaune pour pouvoir modifier notre article -->
            <a href="/modifArticle?id=<?= $myArticle->getIdUser();?>" class="btn btn-warning">Modifier</a>
    <?php }?>
</div>
<?php
require_once(__DIR__ . "/partials/footer.view.php");

// Le symbole && en PHP signifie : ET logique (AND), && = “ET”, il permet de vérifier que plusieurs conditions sont vraies en même temps.