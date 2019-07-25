<?php
    $title = "Édition du profil"; 
    $hideFooter = true;
    use Models\Functions;
?>
<?php ob_start() ?>
<div class="container edit">
    <form action="index.php?action=edit_profile" method="post">
        <h3 class="mb-4">Éditer mon profil</h3>
        <?php Functions::flash(); ?>
        <div class="form-row">
            <div class="form-group col-12">
                <label for="pseudo">Pseudo</label>
                <input type="text" class="form-control" id="pseudo" name="newPseudo" placeholder="Pseudo" value="<?= $_SESSION["username"]; ?>">
            </div>
            <div class="form-group col-12">
                <label for="mail">Mail</label>
                <input type="email" id="mail" class="form-control" name="newMail" placeholder="Mail" value="<?= $_SESSION["mail"]; ?>">
            </div>
            <div class="form-group col-12">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" id="password" class="form-control" name="newPswd" placeholder="Mot de passe">
            </div>
            <div class="form-group col-12">
                <label for="password2">Confirmation du mot de passe</label>
                <input type="password" id="password2" class="form-control" name="newPswd2" placeholder="Confirmation mot de passe">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour mon profil</button>
    </form>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>