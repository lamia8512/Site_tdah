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
                <!-- Lien de redirection vers la liste de tous les articles (/articles : route vers la page qui affiche tous les articles,  btn : classe Bootstrap qui transforme le lien en bouton, btn-primary : classe Bootstrap qui applique un fond bleu au bouton, mt-3 : classe Bootstrap qui ajoute une marge en haut du bouton ) -->
                <a href="/articles" class="btn btn-primary mt-3">Voir tous les articles</a>
        </div>

        <?php
                //Vérifie deux conditions: la 1re est que l'utilisateur est bien connecté donc que la session user existe, et la 2e que l'utilisateur connecté est l'auteur de l'article
                if(isset($_SESSION['user']) && $_SESSION['user']['id_user'] === $myArticle->getIdUser()){
        ?>
                <!-- Lien permettant d'accéder à la page de modification de l'article (<a href="..."> balise HTML de lien permet de naviguer vers une autre page, ici vers la page de modification avec un paramètre get id, avec la méthode getIdUser on récupére l'id de l'utilisateur (auteur) qui a crée l'article, on crée un bouton de couleur jaune pour pouvoir modifier notre article -->
                <a href="/modifArticle?id=<?= $myArticle->getIdArticle();?>" class="btn btn-warning">Modifier</a>
        <?php }?>

        <?php
                // Vérifie si l'utilisateur est autorisé à agir sur l'article (cas 1 : l'utilisateur est connecté ET c'est l'auteur de l'article ou cas 2 : l'utilisateur est connecté ET c'est un administrateur)
            if((isset($_SESSION['user']) && $_SESSION['user']['id_user'] === $myArticle->getIdUser()) || (isset($_SESSION['user']) && $_SESSION['user']['id_role'] === 1)){
        ?>
                <!-- Formulaire pour supprimer un article -->
                <form action="/supprimArticle" method="POST">
                    <!-- Champ caché contenant l'ID de l'article à supprimer (en appelant la méthode GetIdArticle) -->
                    <input type="hidden" name="id" value="<?= $myArticle->getIdArticle() ?>">
                    <!-- Bouton pour envoyer le formulaire -->
                    <button type="submit" class="btn btn-danger mt-3">Supprimer</button>
                </form>
        <?php }?>

        <?php
        // Vérifie si un utilisateur est connecté (session active donc qu'elle existe bien)
        if(isset($_SESSION['user'])){
        ?>
            <!-- Formulaire d'ajout de commentaire -->
            <form method="POST">
                <div class="container">
                    <div class="form-group">
                        <!-- Label du champ commentaire -->
                        <label for="comment" class="form-label mt-3">Laissez un commentaire</label>
                        <!-- Zone de texte pour écrire le commentaire -->
                        <textarea class="form-control" id="comment" name="comment" style="height: 100px"></textarea>
                        <?php
                        // Vérifie s'il existe une erreur liée au champ "comment"
                        if(isset($this->arrayError['comment'])){
                            ?>
                            <!-- Affiche le message d'erreur en rouge -->
                            <p class="text-danger"><?= $this->arrayError['comment']?></p>
                            <?php
                        }
                        ?>
                    </div>
                    <!-- Bouton pour envoyer le formulaire en appelant la méthode addComment qui vient du modèle Comment.php  -->
                    <button type="submit" name="addComment" class="btn btn-success mt-3">Commenter !</button>
                </div>
            </form>
        <?php
        }
        // Vérifie si la variable $comments existe et contient des données
        if(isset($comments)){
            // Parcourt chaque commentaire contenu dans le tableau $comments
            foreach($comments as $comment)
            {
                ?>
                    <!-- Carte Bootstrap pour afficher un commentaire -->
                    <div class="card my-2 text-bg-info">
                    <!-- En-tête de la carte : affiche le pseudo de l'utilisateur -->
                    <div class="card-header">
                        <?= $comment->getPseudo(); ?>
                    </div>
                    <!-- Corps de la carte Bootstrap -->
                    <div class="card-body">
                        <figure>
                        <!-- Bloc de citation contenant le texte du commentaire -->
                        <blockquote class="blockquote">
                            <p><?= $comment->getText(); ?></p>
                        </blockquote>
                        <!-- Pied de citation : affiche la date -->
                        <figcaption class="blockquote-footer">
                            <!-- Si une date de modification existe, on l'affiche sinon on affiche la date de création-->
                            <?= $comment->getModificationDate() ? $comment->getModificationDate() : $comment->getCreationDate(); ?>
                        </figcaption>
                        </figure>
                    </div>
                    </div>
                <?php
            }
        }
    ?>
</div>
    </div>
    
    <?php
    require_once(__DIR__ . "/partials/footer.view.php");

    // Le symbole && en PHP signifie : ET logique (AND), && = “ET”, il permet de vérifier que plusieurs conditions sont vraies en même temps.