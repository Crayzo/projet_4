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
    if(!empty($_POST))
    {
        if(isset($_POST['contenu']) && !empty($_POST['contenu']) && isset($_POST['titre']) && !empty($_POST['titre']))
        {
            $insertChapter = $bdd->prepare('INSERT INTO chapitres (titre, contenu, date_ajout, date_modification) VALUES (?, ?, NOW(), NOW())');
            $insertChapter->execute(array($_POST['titre'], $_POST['contenu']));
            $success = "Le chapitre a bien été ajouté";
        }
        else
        {
            $message = "Tous les champs doivent être complétés !";
        }
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
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
    <title>Ajouter un chapitre</title>
  </head>
  <body>
    <?php include 'includes/navbar.php' ?>
    <div class="container mt-3 text-right">
        <form action="add.php" method="post">
            <div class="form-row">
                <div class="form-group col-12">
                    <input type="text" class="form-control" name="titre" placeholder="Titre du chapitre" value="<?php if(isset($_POST['titre'])) {echo $_POST['titre'];} ?>" requiered>
                </div>
            </div>
            <textarea name="contenu"><?php if(isset($_POST['contenu'])){echo $_POST['contenu'];} ?></textarea>
            <?php if(isset($message)){ ?>
            <p class="text-danger mb-1"><?= $message ?></p>
            <?php } ?>
            <?php if(isset($success)){ ?>
            <p class="text-success mb-1"><?= $success ?></p>
            <?php } ?>
            <button type="submit" class="btn btn-dark">Ajouter</button>
        </form>
    </div>
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