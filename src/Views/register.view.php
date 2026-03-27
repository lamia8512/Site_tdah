<?php
require_once(__DIR__ . "/partials/head.view.php");
?>
<h1>Inscription</h1>
<form method="POST">
    <div class="container">
        <div class="form-group">
            <label for="pseudo" class="form-label">Pseudo :</label>
            <input type="text" name="pseudo" id="pseudo" placeholder="Lulu" class="form-control">
             <?php 
            if(isset($this->errors['pseudo'])){
                ?>
                    <p class="text-danger"><?= $this->errors['pseudo']?></p>
                <?php
            }
            ?>
        </div>
        <div class="form-group">
            <label for="email" class="form-label">Email :</label>
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
            <label for="password" class="form-label">Mot de passe :</label>
            <input type="password" name="password" id="password" class="form-control">
            <?php 
            if(isset($this->errors['password'])){
                ?>
                    <p class="text-danger"><?= $this->errors['password']?></p>
                <?php
            }
            ?>
        </div>
        <button type="submit" name="register" class="btn btn-primary mt-5">Inscription</button>
    </div>
</form>
<?php
require_once(__DIR__ . "/partials/footer.view.php");