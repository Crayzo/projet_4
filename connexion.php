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
    <title>Connexion</title>
  </head>
  <body>
    <?php include 'includes/navbar.php' ?>
    <div class="container">
        <h3 class="text-center mt-2 mb-4">Connexion</h3>
        <form action="connexion.php" method="post">
            <div class="form-group">
                <input type="text" class="form-control" name="idConnect" placeholder="Votre pseudo ou adresse mail" requiered>
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="passwordConnect" placeholder="Votre mot de passe" requiered>
            </div>
            <?php if(isset($message)){ ?>
            <p class="text-danger"><?= $message ?></p>
            <?php } ?>
            <button type="submit" class="btn btn-primary" name="submit">Se connecter !</button>
            <p class="mt-2">Vous n'avez pas de compte ? <a href="inscription.php">S'inscrire</a></p>
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