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
    $pseudo = htmlspecialchars($_POST['pseudo']);
    $mail = htmlspecialchars($_POST['mail']);
    $mail2 = htmlspecialchars($_POST['mail2']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    if(!empty($_POST['pseudo']) && !empty($_POST['mail']) && !empty($_POST['mail2']) && !empty($_POST['password']) && !empty($_POST['password2']))
    {
        $pseudoLength = strlen($pseudo);
        if($pseudoLength <= 25)
        {
            $reqPseudo = $bdd->prepare("SELECT * FROM membres WHERE pseudo = ?");
            $reqPseudo->execute(array($pseudo));
            $pseudoExist = $reqPseudo->rowCount();
            if($pseudoExist === 0)
            {
                if($mail === $mail2)
                {
                    if(filter_var($mail, FILTER_VALIDATE_EMAIL))
                    {
                        $reqMail = $bdd->prepare("SELECT * FROM membres WHERE mail = ?");
                        $reqMail->execute(array($mail));
                        $mailExist = $reqMail->rowCount();
                        if($mailExist === 0)
                        {
                            if($password === $password2)
                            {
                                $passHash = password_hash($password, PASSWORD_DEFAULT);
                                $insertMember = $bdd->prepare("INSERT INTO membres (pseudo, mail, password) VALUES (?, ?, ?)");
                                $insertMember->execute(array($pseudo, $mail, $passHash));
                                $success = "Votre compte a bien été créé !";
                            }
                        }
                        else
                            $message = "Adresse mail déjà utilisée !";
                    }
                    else
                        $message = "Votre adresse mail n'est pas valide.";
                }
                else
                    $message = "Vos adresses mail ne correspondent pas !";
            }
            else
                $message = "Le pseudo existe déjà !";
        }
        else
            $message = "Votre pseudo ne doit pas dépasser 25 caractères.";
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
    <title>Inscription</title>
  </head>
  <body>
    <?php include 'includes/navbar.php' ?>
    <div class="container inscription py-3">
        <form action="inscription.php" method="post">
            <h3 class="text-center">Inscription</h3>
            <div class="form-group">
                <label for="pseudo">Pseudo</label>
                <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Votre pseudo" value="<?php if(isset($pseudo)){echo $pseudo;} ?>" requiered>
            </div>
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="mail">Mail</label>
                    <input type="mail" class="form-control" name="mail" id="mail" placeholder="Votre mail" value="<?php if(isset($mail)){echo $mail;} ?>" requiered>
                </div>
                <div class="form-group col-12">
                    <label for="mail2">Confirmation du mail</label>
                    <input type="mail" class="form-control" name="mail2" id="mail2" placeholder="Confirmation de votre mail" value="<?php if(isset($mail2)){echo $mail2;} ?>" requiered>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-12">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Votre mot de passe" requiered>
                </div>
                <div class="form-group col-12">
                    <label for="password2">Confirmation mot de passe</label>
                    <input type="password" class="form-control" name="password2" id="password2" placeholder="Confirmation de votre mot de passe" requiered>
                </div>
                <!-- Erreur -->
                <?php if(isset($message)){ ?>
                <p class="text-danger"><?= $message ?></p>
                <?php } ?>
                <!-- Succès -->
                <?php if(isset($success)){ ?>
                <p class="text-success"><?= $success ?></p>
                <?php } ?>
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