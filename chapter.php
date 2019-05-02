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
if(isset($_GET['id']) && $_GET['id'] > 0)
{
    // Récupération du chapitre
    $getID = intval($_GET['id']);
    $req = $bdd->prepare('SELECT id, titre, contenu FROM chapitres WHERE id = ?');
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
    <div id="main">
			<?php include 'includes/navbar.php'; ?>
			<section id="chapter-text">
				<div>
					<h1 class="text-center"><?= $donnees['titre']; ?></h1>
					<div class="divider div-transparent mb-5"></div>
					<p><?= $donnees['contenu']; ?></p>
				</div>
			</section>
            <section>
                <div class="container mb-5">
                    <form action="chapter.php" method="post">
                        <?php if(isset($_SESSION['id'])) { ?>
                        <h3 class="text-center mb-4">Ajouter un commentaire</h3>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <textarea name="commentaire" class="form-control" placeholder="Votre commentaire" requiered></textarea>
                            </div>
                        </div>
                        <?php if(isset($message)){ ?>
                        <p class="text-danger"><?= $message ?></p>
                        <?php } ?>
                        <button type="submit" class="btn btn-primary" name="submit_commentaire">Envoyer</button>
                        <?php } else { ?> 
                        <p class="my-0">Vous devez être connecté(e) pour ajouter un commentaire !</p>
                        <a href="connexion.php">Se connecter</a>
                        <?php } ?>       
                    </form>
                </div>
            </section>
			<?php include 'includes/footer.php' ?>
			<?php $req->closeCursor(); } ?>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
  </body>
</html>
