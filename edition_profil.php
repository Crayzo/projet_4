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
    if(isset($_POST['newMail']) && !empty($_POST['newMail']) && $_POST['newMail'] !== $user['mail'])
    {
        $newMail = htmlspecialchars($_POST['newMail']);
        if(filter_var($newMail, FILTER_VALIDATE_EMAIL))
        {
            $reqMail = $bdd->prepare('SELECT * FROM membres WHERE mail = ?');
            $reqMail->execute(array($newMail));
            $mailExist = $reqMail->rowCount();
            if($mailExist === 0)
            {
                $insertMail = $bdd->prepare('UPDATE membres SET mail = ? WHERE id = ?');
                $insertMail->execute(array($newMail, $_SESSION['id']));
                $_SESSION['mail'] = $newMail;
                $success = "Votre compte a bien été mis à jour";
            }
            else
                $message = "Adresse mail déjà utilisée !";
        }
        else
            $message = "Votre adresse mail n'est pas valide.";
    }
    if(isset($_POST['newMdp']) && !empty($_POST['newMdp']) && $_POST['newMdp'] !== $user['password'] && isset($_POST['newMdp2']) && !empty($_POST['newMdp2']) && $_POST['newMdp2'] !== $user['password'])
    {
        $mdp = password_hash($_POST['newMdp'], PASSWORD_DEFAULT);
        $mdp2 = $_POST['newMdp2'];
        $isPasswordCorrect = password_verify($mdp2, $mdp);
        if($isPasswordCorrect)
        {
            $reqMdp = $bdd->prepare('SELECT password FROM membres WHERE id = ?');
            $reqMdp->execute(array($_SESSION['id']));
            $resultat = $reqMdp->fetch();
            $verificationMdp = password_verify($mdp2, $resultat['password']);
            if($verificationMdp === false)
            {
                $insertMdp = $bdd->prepare('UPDATE membres SET password = ? WHERE id = ?');
                $insertMdp->execute(array($mdp, $_SESSION['id']));
                $success = "Votre compte a bien été mis à jour";
            }
            else
                $message = "Veuillez saisir un mot de passe différent de votre mot de passe actuel !";
        }
        else
            $message = "Vos deux mots de passe ne correspondent pas !";

    }
}
else
    header('Location: index.php');
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
    <title>Édition du profil</title>
  </head>
  <body>
    <?php include 'includes/navbar.php' ?>
    <div class="container edit">
        <form action="edition_profil.php" method="post">
            <h3 class="mb-4">Éditer mon profil</h3>
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="pseudo">Pseudo</label>
                    <input type="text" class="form-control" id="pseudo" name="newPseudo" placeholder="Pseudo" value="<?= $_SESSION["pseudo"]; ?>" requiered>
                </div>
                <div class="form-group col-12">
                    <label for="mail">Mail</label>
                    <input type="mail" id="mail" class="form-control" name="newMail" placeholder="Mail" value="<?= $_SESSION["mail"]; ?>" requiered>
                </div>
                <div class="form-group col-12">
                    <label for="password">Mot de passe</label>
                    <input type="password" id="password" class="form-control" name="newMdp" placeholder="Mot de passe" requiered>
                </div>
                <div class="form-group col-12">
                    <label for="password2">Confirmation du mot de passe</label>
                    <input type="password" id="password2" class="form-control" name="newMdp2" placeholder="Confirmation mot de passe" requiered>
                </div>
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