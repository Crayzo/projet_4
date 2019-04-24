<?php
session_start();
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=projet_4', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}
?>
<!doctype html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/favicon/book.gif" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <!-- CSS -->
    <link rel="stylesheet" href="style.css?t=<?= time() ?>">
    <!-- Font Family -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <title>Inscription</title>
  </head>
  <body>
    <?php include 'includes/navbar.php' ?>
    <div class="container inscription">
        <h3 class="text-center mt-2">Inscription</h3>
        <form action="inscription.php" method="post">
            <div class="form-group">
                <label for="pseudo">Pseudo</label>
                <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Votre pseudo" requiered>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="mail">Mail</label>
                    <input type="mail" class="form-control" name="mail" id="mail" placeholder="Votre mail" requiered>
                </div>
                <div class="form-group col-md-6">
                    <label for="mail2">Confirmation du mail</label>
                    <input type="mail" class="form-control" name="mail2" id="mail2" placeholder="Confirmation de votre mail" requiered>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Votre mot de passe" requiered>
                </div>
                <div class="form-group col-md-6">
                    <label for="password2">Confirmation mot de passe</label>
                    <input type="password" class="form-control" name="password2" id="password2" placeholder="Confirmation de votre mot de passe" requiered>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Je m'inscris</button>
            <p class="mt-2">Vous avez un compte ? <a href="connexion.php">Se connecter</a></p>
        </form>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
  </body>
</html>