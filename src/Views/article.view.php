<?php
require_once(__DIR__ . "/partials/head.view.php");
?>   
<?php 
        //On vérifie que la variable $myArticles existe (que des articles ont bien été crées par des utilisateurs)
        if(isset($myArticles )){
            //On parcourt tous les articles (tableau d'objets Article)
            foreach($myArticles as $article)
            {
                ?>
                    <!--Création d’une carte Bootstrap pour afficher un article, my-2 = marge verticale, text-bg-info = fond bleu clair-->
                    <div class="card my-2 text-bg-info">
                    <!--En-tête de la carte-->
                    <div class="card-header">
                        <!-- ✅ On récupère le pseudo via le tableau $authors ($article->getIdUser() → récupère l’ID de l’auteur et ->getPseudo() → affiche le pseudo) -->
                        <p><?= $authors[$article->getIdUser()]->getPseudo(); ?></p>
                    </div>
                     <!--Corps de la carte-->
                    <div class="card-body">
                        <figure>
                        <!--Bloc de citations (style citation)-->
                        <blockquote class="blockquote">
                            <!--On récupère le titre en appelant la méthode getTitle-->
                            <p><?= $article->getTitle(); ?></p>
                        </blockquote>
                        </figure>
                    </div>
                    <div class="card-body">
                        <figure>
                        <!--Bloc de citations (style citation)-->
                        <blockquote class="blockquote">
                            <!--On récupère le texte de notre article en appelant la méthode getText--->
                            <p><?= $article->getText(); ?></p>
                        </blockquote>
                        </figure>         
                    </div>
                    </div>
                <?php
            }
        }
    ?>

</div>
<?php
require_once(__DIR__ . "/partials/footer.view.php");