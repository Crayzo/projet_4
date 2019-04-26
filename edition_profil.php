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
if(isset($_SESSION['id']))
{
    $req = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
    $req->execute(array($_SESSION['id']));
    $user = $req->fetch();
    if(isset($_POST['newPseudo']) && !empty($_POST['newPseudo']) && $_POST['newPseudo'] !== $user['pseudo'])
    {
        $newPseudo = htmlspecialchars($_POST['newPseudo']);
        $pseudoLength = strlen($newPseudo);
        if($pseudoLength <= 25)
        {
            $reqPseudo = $bdd->prepare('SELECT * FROM membres WHERE pseudo = ?');
            $reqPseudo->execute(array($newPseudo));
            $pseudoExist = $reqPseudo->rowCount();
            if(!$pseudoExist)
            {
                $insertPseudo = $bdd->prepare('UPDATE membres SET pseudo = ? WHERE id = ?');
                $insertPseudo->execute(array($newPseudo, $_SESSION['id']));
                $_SESSION['pseudo'] = $newPseudo;
                $success = "Votre compte a bien été mis à jour";
            }
            else
                $message = "Le pseudo existe déjà !";
        }
        else
            $message = "Votre pseudo ne doit pas dépasser 25 caractères !";
    }
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
    <title>Édition</title>
  </head>
  <body>
    <?php include 'includes/navbar.php' ?>
    <div class="container">
        <h3 class="text-center mt-2 mb-4">Edition de mon profil</h3>
        <form action="edition_profil.php" method="post">
            <div class="form-group">
                <label>Pseudo</label>
                <input type="text" class="form-control" name="newPseudo" placeholder="Pseudo" value="<?= $_SESSION["pseudo"]; ?>" requiered>
            </div>
            <div class="form-group">
                <label for="pseudo">Mail</label>
                <input type="mail" class="form-control" name="newMail" placeholder="Mail" value="<?= $_SESSION["mail"]; ?>" requiered>
            </div>
            <div class="form-group">
                <label for="pseudo">Mot de passe</label>
                <input type="password" class="form-control" name="newMdp" placeholder="Mot de passe" requiered>
            </div>
            <div class="form-group">
                <label for="pseudo">Confirmation du mot de passe</label>
                <input type="password" class="form-control" name="newMdp2" placeholder="Confirmation mot de passe" requiered>
            </div>
            <?php if(isset($message)){ ?>
            <p class="text-danger"><?= $message ?></p>
            <?php } ?>
            <?php if(isset($success)){ ?>
            <p class="text-success"><?= $success ?></p>
            <?php } ?>
            <button type="submit" class="btn btn-primary">Mettre à jour mon profil</button>
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