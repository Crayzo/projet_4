<?php 
    $title = "Connexion";
    $hideFooter = true;
?>
<?php ob_start(); ?>
<div class="container login">
    <form action="" method="post">
        <h3 class="text-center mb-4">Connexion</h3>
        <div class="form-row">
            <div class="form-group col-12">
                <input type="text" class="form-control" name="idConnect" placeholder="Votre pseudo ou adresse mail" value="<?php if(isset($idConnect)) echo $idConnect; ?>" required>
            </div>
            <div class="form-group col-12">
                <input type="password" class="form-control" name="passwordConnect" placeholder="Votre mot de passe" required>
            </div>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" name="rememberMe" type="checkbox" id="checkbox">
            <label class="form-check-label" for="checkbox">Se souvenir de moi</label>
        </div>
        <?php if(isset($error)){ ?>
            <p class="text-danger"><?= $error ?></p>
        <?php } ?>
        <button type="submit" class="btn btn-primary" name="submit">Se connecter !</button>
        <p class="mt-2">Vous n'avez pas de compte ? <a href="index.php?action=register">S'inscrire</a></p>
    </form>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>