<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog TDAH</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
  <header>
    <div class="container">
      <div class="logo">
        <img src="assets/img/logo.png" alt="logo du site sur le TDAH">
      </div> 
    <?php
    // Nettoie l'URL, enlève les paramètres GET et le slash final (récupère uniquement le chemin de l'URL sans les paramètres GET comme ?id=1)
    $currentPage = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    // Si l'URL est vide (ce qui arrive quand on est sur la page d'accueil "/")
    if ($currentPage === '') {
        // On remplace la valeur vide par "/" pour représenter correctement la page d'accueil
        $currentPage = '/';
    }
    ?>
    <nav>
      <input type="checkbox" id="menu-toggle" class="menu-checkbox">
    <label for="menu-toggle" class="menu-burger">☰</label>
      <ul>
        <!-- Si la page actuelle est "/" (accueil) OU "/index.php" alors on ajoute la classe "red" pour mettre le lien en rouge -->
        <li><a class="<?= ($currentPage === '/' || $currentPage === '/index.php') ? 'red' : '' ?>" href="/">Accueil</a></li>
         <!-- Si la page actuelle est "/tdah" alors on ajoute la classe "red" pour mettre le lien en rouge -->
        <li><a class="<?= $currentPage === '/tdah' ? 'red' : '' ?>" href="/tdah">TDAH</a></li>
        <li><a class="<?= $currentPage === '/diagnostic' ? 'red' : '' ?>" href="/diagnostic">Diagnostic</a></li>
        <li><a class="<?= $currentPage === '/activites' ? 'red' : '' ?>" href="/activites">Activités</a></li>
        <?php
        //s'il existe une session user ce qui signifie que la personne est connectée
        if(isset( $_SESSION["user"])){
          ?>
          <li><a href="/deconnexion">Déconnexion</a></li>
        <?php
        //si la session n'existe pas alors la personne doit s'inscrire puis se connecter
        }else{
          ?>
          <li><a href="/inscription">Inscription</a></li>
          <li><a href="/connexion">Connexion</a></li>
      <?php
      }
      ?>
      </ul>
    </nav>
    </div>
  </header>

  
<!-- 
  $_SERVER est une variable superglobale PHP (variable intégrée à PHP, disponible dans tous les fichiers et fonctions)
  elle contient des infos sur la requête HTTP
-->

<!-- 
  $currentPage = page actuelle
  rtrim -> enlève le / à la fin de l’URL
  parse_url -> je prends l’URL et je récupère seulement le chemin (la page)
  $_SERVER['REQUEST_URI'] -> récupère l’URL complète ex : /tdah?page=2
  parse_url(..., PHP_URL_PATH) -> garde seulement /tdah
-->












