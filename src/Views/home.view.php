<?php
require_once(__DIR__ . "/partials/head.view.php");
?>

    <main>
        <?php if(isset($_SESSION['user'])) { ?>
            <h1>Bienvenue <?= $_SESSION['user']['pseudo'] ?></h1>
            <a href="/ajoutArticle" class="my-btn2">Poster un article</a>
            <a href="/articles" class="my-btn3">Voir tous les articles</a>
        <?php } ?>

        <div class="titre">
            <p><span>Mieux vivre</span> avec le trouble du déficit de<br>l’attention avec ou sans hyperactivité (TDAH)</p>
        </div>

        <section class="col_12 tdah">
            <img src="/assets/img/cerveaux-tdah.jpg" alt="illustration cerveaux des tdah">
        </section>

        <section class="row">
            <div class="col_4 bloc">
                <p class="large">TDAH</p>
                <p class="padding">• Qu’est-ce que le TDAH ?</p>
                <p class="padding">• Quelles sont les symptômes ?</p>
                <p class="padding">• Quelles sont les conséquences ?</p>
            </div>

            <div class="col_4 bloc">
                <p class="large">Diagnostic</p>
                <p class="padding">• Neurologues</p>
                <p class="padding">• Pédopsychiatres</p>
                <p class="padding">• Ergothérapeutes</p>
            </div>
        </section>

        <section class="row">
            <div class="col_4 bloc">
                <p class="large">Activités</p>
                <p class="padding">• Sports</p>
                <p class="padding">• Art-thérapie</p>
                <p class="padding">• Relaxation</p>
            </div>
        </section>

        <section>
            <div class="col_12">
                <p class="redcenter">Astuces pratiques</p>
                <p class="center">S'outiller pour mieux vivre avec son handicap au quotidien</p>
            </div>
        </section>

        <section>
            <div class="col_12">
                <a href="/astuces" class="my-btn">Astuces</a>
            </div>
        </section>
    </main>

<?php 
require_once(__DIR__ . "/partials/footer.view.php"); 
