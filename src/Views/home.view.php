<?php
require_once(__DIR__ . "/partials/head.view.php");
// s'il existe une session user ce qui signifie que la personne est connectée
if(isset($_SESSION['user'])){
    ?>
    <!-- Le message Bonjour apparaît suivi du nom de la personne connecté dans écho php -->
    <h1>Bonjour <?=$_SESSION['user']['pseudo']?></h1>
    <?php
}else{
?>
    <h1>Bonjour !</h1>
<?php
}
require_once(__DIR__ . "/partials/footer.view.php");