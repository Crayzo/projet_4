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
if(isset($_SESSION['id'], $_SESSION['admin']) && !empty($_SESSION['id']) && !empty($_SESSION['admin']) && $_SESSION['admin'] == true)
{
    $reqReports = $bdd->query('SELECT * FROM signalements ORDER BY id DESC LIMIT 0,10');
    if(isset($_GET['approve']) && $_GET['approve'] > 0)
    {
        $getApprove = intval($_GET['approve']);
        $reqApprove = $bdd->prepare('DELETE FROM signalements WHERE id = ?');
        $reqApprove->execute(array($getApprove));
        if(isset($_GET['delete']) && $_GET['delete'] > 0)
        {
            $getDelete = intval($_GET['delete']);
            $reqDelete = $bdd->prepare('DELETE FROM commentaires WHERE id = ?');
            $reqDelete->execute(array($getDelete));
        }
        header('Location: reports.php');
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

    <?php
    $nbReports = $reqReports->rowCount();
    if($nbReports > 0){
         while($reports = $reqReports->fetch()){ 
            /* Membres */
            $reqUser = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
            $reqUser->execute(array($reports['id_membre']));
            $user = $reqUser->fetch();
            /* Commentaires */
            $reqCommentaire = $bdd->prepare('SELECT *, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %H:%i:%s\') AS date_commentaire_fr FROM commentaires WHERE id = ?');
            $reqCommentaire->execute(array($reports['id_commentaire']));
            $commentaire = $reqCommentaire->fetch();
            /* Auteur du commentaire */
            $reqAuteurCommentaire = $bdd->prepare('SELECT * FROM membres WHERE id = ?');
            $reqAuteurCommentaire->execute(array($commentaire['id_auteur']));
            $auteurCommentaire = $reqAuteurCommentaire->fetch();
        ?>
        <div class="container">
            <div class="card my-3">
                <div class="card-header mb-1">
                    <p class="my-0"><b>Signalé par :</b> <?= $user['pseudo'] ?></p>
                    <p class="my-0"><b>Message :</b> <?= $reports['message'] ?></p>
                </div>
                <!-- Entête du commentaire -->
                <div class="card-header d-flex justify-content-between">
                    <div class="align-self-center">
                        <strong><?= $auteurCommentaire['pseudo'] ?></strong> le <?= $commentaire['date_commentaire_fr'] ?> 
                    </div>
                    <div>
                        <a class="btn btn-outline-success btn-sm" href="reports.php?approve=<?= $reports['id'] ?>">Approuver</a>
                        <a class="btn btn-outline-danger btn-sm" href="reports.php?approve=<?= $reports['id'] ?>&delete=<?= $reports['id_commentaire']; ?>" onclick="return(confirm('Voulez-vous vraiment supprimer ce commentaire ?'));">Supprimer</a>
                    </div>       
                </div>
                <!-- Corps du commentaire -->
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                    <p class="mb-0"><?= $commentaire['commentaire'] ?></p>
                    </blockquote>
                </div>
            </div>
        </div>
    <?php } $reqReports->closeCursor(); } else echo "<p class='text-center mt-3'>Aucun signalement à afficher.<br><a href='index.php'>Aller à l'accueil</a></p>"; ?>
    <?php } else header('Location: index.php'); ?> 
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
  </body>
</html>