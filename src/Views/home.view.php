<?php
require_once(__DIR__ . "/partials/head.view.php");
if(isset($_SESSION['user'])){
    ?>
    <h1>Bonjour <?=$_SESSION['user']['pseudo']?></h1>
    <?php
}else{
?>
    <h1>Bonjour !</h1>
<?php
}
require_once(__DIR__ . "/partials/footer.view.php");