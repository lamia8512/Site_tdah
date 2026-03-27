<?php
require_once(__DIR__ . "/partials/head.view.php");
?>
<h1>Connexion</h1>
<form method="POST">
    <div class="container">
        <div class="form-group">
            <label for="email" class="form-label">Donne moi ton email :</label>
            <input type="email" name="email" id="email" placeholder="Lulu@gmail.com" class="form-control">
            <?php 
            if(isset($this->errors['email'])){
                ?>
                    <p class="text-danger"><?= $this->errors['email']?></p>
                <?php
            }
            ?>
        </div>
        <div class="form-group">
            <label for="password" class="form-label">Donne moi ton mot de pase :</label>
            <input type="password" name="password" id="password" class="form-control">
            <?php 
            if(isset($this->errors['password'])){
                ?>
                    <p class="text-danger"><?= $this->errors['password']?></p>
                <?php
            }
            ?>
        </div>
        <button type="submit" name="login" class="btn btn-warning mt-5">Connexion</button>
    </div>
</form>
<?php
require_once(__DIR__ . "/partials/footer.view.php");
?>