<?php
session_start();
// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=projet_4', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}
// On récupère les 4 derniers chapitres
$req = $bdd->prepare('SELECT id, titre, contenu, DATE_FORMAT(date_ajout, \'%d/%m/%Y\') AS date_ajout_fr, DATE_FORMAT(date_modification, \'%d/%m/%Y\') AS date_modification_fr FROM chapitres ORDER BY id DESC');
$req->execute();
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
    <title>Chapitres</title>
  </head>
  <body>
    <div id="main">
        <?php include 'includes/navbar.php' ?>
        <!-- Chapters -->
        <section class="chapters">
            <h2 class="text-center">Tous les chapitres</h2>
            <div class="divider div-black mb-5"></div>
            <?php if(isset($_SESSION['id']) && $_SESSION['admin'] == 1){ ?>
            <div class="d-flex justify-content-md-end justify-content-center mb-4">
                <a href="add.php" class="btn btn-dark add-btn">Ajouter un chapitre</a>
            </div>
            <?php } ?>
            <div class="container">
                <div class="row">
                    <?php while($donnees = $req->fetch())
                    {
                    ?>
                    <div class="book col-12 col-sm-5 offset-sm-1 mx-auto text-center">
                        <h3><?= htmlspecialchars($donnees['titre']); ?></h3>
                        <span>Ajouté le <?= htmlspecialchars($donnees['date_ajout_fr']) ?></span><br>
                        <span>Dernière modification le <?= htmlspecialchars($donnees['date_modification_fr']) ?></span>
                        <a href="chapter.php?id=<?= $donnees['id']; ?>" class="btn btn-outline-dark mt-3">Lire le chapitre</a>
                    </div>
                    <?php
                    }
                    $req->closeCursor();
                    ?>
                </div> 
            </div>
        </section>
        <!-- Footer -->
        <?php include 'includes/footer.php' ?>
    </div> 
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
  </body>
</html>