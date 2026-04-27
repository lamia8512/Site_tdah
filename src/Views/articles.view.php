<?php
require_once(__DIR__ . "/partials/head.view.php");
?>   
<?php 
        // On vérifie que la variable $myArticles existe (que des articles ont bien été crées par des utilisateurs)
        if(isset($myArticles )){
            // On parcourt tous les articles (tableau d'objets Article)
            foreach($myArticles as $article)
            {
                ?>
                <div class="container">
                    <!-- Création d'une carte Bootstrap centrée avec un fond vert et une marge (my-4 = marge haut et bas, text-bg-vert = fond vert) -->
                    <div class="card text-center text-bg-success my-4">
                    <!-- En-tête de la carte -->
                    <div class="card-header">
                        <!-- On récupère le pseudo via le tableau $authors ($article->getIdUser() → récupère l’ID de l’auteur et ->getPseudo() → affiche le pseudo) -->
                        <p><?= $authors[$article->getIdUser()]->getPseudo(); ?></p>
                    </div>
                     <!-- Corps de la carte -->
                    <div class="card-body">
                        <figure>
                        <!-- Bloc de citations (style citation) -->
                        <blockquote class="blockquote">
                            <!-- On récupère le titre en appelant la méthode getTitle -->
                            <p><?= $article->getTitle(); ?></p>
                        </blockquote>
                        </figure>
                    </div>
                    <div class="card-body">
                        <figure>
                        <!-- Bloc de citations (style citation) -->
                        <blockquote class="blockquote">
                            <!-- On récupère le texte de notre article en appelant la méthode getText-->
                            <p><?= $article->getText(); ?></p>
                        </blockquote>
                        </figure>         
                    </div>
                    <!-- Formulaire HTML qui permet d'envoyer une requête en GET vers la page /affichArticle -->
                    <form method="GET" action="/affichArticle">
                        <!-- Champ caché (non visible pour l'utilisateur) qui contient l'ID de l'article -->
                        <!-- name="id" correspond à la clé récupérée dans $_GET['id'] dans le controller -->
                        <!-- value contient l'ID de l'article actuel (grâce à la méthode getIdArticle()) -->
                        <input type="hidden" name="id" value="<?= $article->getIdArticle(); ?>">

                        <!-- Bouton qui envoie le formulaire -->
                        <!-- type="submit" déclenche l'envoi du formulaire -->
                        <!-- class="btn btn-info my-4" applique un style Bootstrap (bouton bleu + marge haut et bas) -->
                        <button type="submit" class="btn btn-info my-4">Voir +</button>
                    </form>
                    </div>
                </div> 
                <?php
            }
        }
    ?>
</div>
<?php
require_once(__DIR__ . "/partials/footer.view.php");