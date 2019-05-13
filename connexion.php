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
if(isset($_SESSION["id"]))
{
    header("Location: index.php");
}
if(!empty($_POST))
{
    $idConnect = htmlspecialchars($_POST['idConnect']);
    $passwordConnect = $_POST['passwordConnect'];
    if(!empty($idConnect) && !empty($passwordConnect))
    {
        // Récupération de l'utilisateur et de son pass hashé
        $req = $bdd->prepare("SELECT * FROM membres WHERE pseudo = :pseudo OR mail = :mail");
        $req->execute(array(
            'pseudo' => $idConnect,
            'mail' => $idConnect));
        $resultat = $req->fetch();
        // Comparaison du pass envoyé via le formulaire avec la base
        $isPasswordCorrect = password_verify($passwordConnect, $resultat["password"]);
        if($resultat)
        {
            if($isPasswordCorrect)
            {
                $_SESSION['id'] = $resultat['id'];
                $_SESSION['pseudo'] = $resultat['pseudo'];
                $_SESSION['mail'] = $resultat['mail'];
                $_SESSION['admin'] = $resultat['admin'];
                header("Location: index.php");
            }
            else
                $message = "Mauvais mot de passe !";
        }
        else
            $message = "Mauvais identifiant !";
    }
    else
        $message = "Tous les champs doivent être complétés !";
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
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <title>Connexion</title>
  </head>
  <body>
    <?php include 'includes/navbar.php' ?>
    <div class="container connexion">
        <form action="connexion.php" method="post">
            <h3 class="text-center mb-4">Connexion</h3>
            <div class="form-row">
                <div class="form-group col-12">
                    <input type="text" class="form-control" name="idConnect" placeholder="Votre pseudo ou adresse mail" requiered>
                </div>
                <div class="form-group col-12">
                    <input type="password" class="form-control" name="passwordConnect" placeholder="Votre mot de passe" requiered>
                </div>
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