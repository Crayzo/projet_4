<?php
// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=projet_4', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}
if(isset($_GET['id']) && $_GET['id'] > 0)
{
    // Récupération du chapitre
    $getID = intval($_GET['id']);
    $req = $bdd->prepare('SELECT id, titre, contenu FROM book WHERE id = ?');
    $req->execute(array($getID));
    $donnees = $req->fetch();
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
    <title><?php if(isset($donnees['id'])){echo $donnees['titre'];} else echo "Erreur";  ?></title>
  </head>
  <body>
    <?php if(!isset($donnees['id'])){echo "Erreur : Ce chapitre n'existe pas !";} else { ?>
    <?php include 'includes/navbar.php'; ?>
    <section>
       <div class="slider">
            <div id="chapter-image">
                <img src="assets/img/3.jpg" alt="Responsive image">
            </div>
            <div id="chapter-text">
                <h1><?= $donnees['titre']; ?></h1>
                <div class="divider div-transparent mb-5"></div>
                <p><?= $donnees['contenu']; ?></p>
            </div>
       </div>
    </section>
    <?php include 'includes/footer.php' ?>
    <?php } ?>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
  </body>
</html>
