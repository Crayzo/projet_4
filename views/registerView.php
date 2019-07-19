<?php
    $title = "Inscription";
    $hideFooter = true;
?>
<?php ob_start(); ?>
<div class="container inscription py-3">
    <form method="post">
        <h3 class="text-center">Inscription</h3>
        <?php Project\Models\Functions::flash(); ?>
        <div class="form-group">
            <label for="pseudo">Pseudo</label>
            <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Votre pseudo" value="<?php if(isset($pseudo)){echo $pseudo;} ?>" required>
        </div>
        <div class="form-row">
            <div class="form-group col-12">
                <label for="mail">Mail</label>
                <input type="email" class="form-control" name="mail" id="mail" placeholder="Votre mail" value="<?php if(isset($mail)){echo $mail;} ?>" required>
            </div>
            <div class="form-group col-12">
                <label for="mail2">Confirmation du mail</label>
                <input type="email" class="form-control" name="mail2" id="mail2" placeholder="Confirmation de votre mail" value="<?php if(isset($mail2)){echo $mail2;} ?>" required>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-12">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Votre mot de passe" required>
            </div>
            <div class="form-group col-12">
                <label for="password2">Confirmation mot de passe</label>
                <input type="password" class="form-control" name="password2" id="password2" placeholder="Confirmation de votre mot de passe" required>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Je m'inscris</button>
        <p class="mt-2">Vous avez un compte ? <a href="index.php?action=login">Se connecter</a></p>
    </form>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>