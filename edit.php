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
if(isset($_SESSION['id']) && $_SESSION['admin'] == 1)
{
    if(isset($_GET['id']) && $_GET['id'] > 0)
    {
        $getID = intval($_GET['id']);
        $req = $bdd->prepare("SELECT * FROM chapitres WHERE id = ?");
        $req->execute(array($getID));
        $donnees = $req->fetch();
        if(!empty($_POST))
        {
            if(isset($_POST['contenu']) && !empty($_POST['contenu']) && isset($_POST['titre']) && !empty($_POST['titre']))
            {
                $insertContenu = $bdd->prepare('UPDATE chapitres SET contenu = ?, titre = ? WHERE id = ?');
                $insertContenu->execute(array($_POST['contenu'], $_POST['titre'], $getID));
                $donnees["contenu"] = $_POST['contenu'];
                $donnees["titre"] = $_POST['titre'];
                $success = "Le chapitre a bien été modifié !";
            }
            else
                $message = "Tous les champs doivent être complétés !";
        }
    }
}
else
    header("Location: index.php");
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
    <title><?php if(isset($donnees['id'])){echo $donnees['titre'];} else echo "Erreur";  ?></title>
  </head>
  <body>
    <?php if(!isset($donnees['id'])){echo "Erreur : Ce chapitre n'existe pas !";} else { ?>
    <?php include 'includes/navbar.php' ?>
    <div class="container mt-3 text-right">
        <form action="edit.php?id=<?= $getID ?>" method="post">
            <div class="form-row">
                <div class="form-group col-12">
                    <input type="text" class="form-control" name="titre" value="<?= $donnees['titre'] ?>" requiered>
                </div>
            </div>
            <textarea name="contenu"><?= $donnees['contenu'] ?></textarea>
            <?php if(isset($message)){ ?>
            <p class="text-danger mb-1"><?= $message ?></p>
            <?php } ?>
            <?php if(isset($success)){ ?>
            <p class="text-success mb-1"><?= $success ?></p>
            <?php } ?>
            <button type="submit" class="btn btn-dark">Modifier</button>
        </form>
    </div>
    <?php } ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=0ymxvkk8uy5skowdciteng030bzu94w3024imvbtq9xgrrqz"></script>
    <script>tinymce.init({selector: "textarea",});</script>
    <script src="script.js"></script>
  </body>
</html>