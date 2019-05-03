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
    if(isset($_POST['submit_commentaire']))
    {
        if(isset($_SESSION['pseudo'], $_POST['commentaire']) && !empty($_SESSION['pseudo']) && !empty($_POST['commentaire']))
        {
            $postCommentaire = htmlspecialchars($_POST['commentaire']);
            $insertCommentaire = $bdd->prepare('INSERT INTO commentaires (commentaire, id_chapitre, id_auteur, date_commentaire) VALUES (?, ?, ?, NOW())');
            $insertCommentaire->execute(array($postCommentaire, $getID, $_SESSION['id']));
            $success = "Votre commentaire a été envoyé avec succès";
        }
        else
            $message = "Tous les champs doivent être complétés !";
    }
    $commentaires = $bdd->prepare('SELECT *, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %H:%i:%s\') AS date_commentaire_fr FROM commentaires WHERE id_chapitre = ? ORDER BY id DESC');
    $commentaires->execute(array($getID));
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
					<h1 class="text-center mt-3"><?= $donnees['titre']; ?></h1>
					<div class="divider div-transparent mb-4"></div>
					<p><?= $donnees['contenu']; ?></p>
				</div>
			</section>
            <section>
                <div class="container mb-5">
                    <form method="post">
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
                        <?php if(isset($success)){ ?>
                        <p class="text-success"><?= $success ?></p>
                        <?php } ?>
                        <button type="submit" class="btn btn-outline-secondary w-100" name="submit_commentaire">Envoyer</button>
                        <?php } else { ?> 
                        <p class="my-0">Vous devez être connecté(e) pour ajouter un commentaire !</p>
                        <a href="connexion.php">Se connecter</a>
                        <?php } ?>
                    </form>
                    <?php while($commentaire = $commentaires->fetch()) {
                        $reqUser = $bdd->prepare('SELECT pseudo FROM membres WHERE id = ?');
                        $reqUser->execute(array($commentaire['id_auteur']));
                        $user = $reqUser->fetch();
                    ?>
                    <div class="card mt-3">
                        <div class="card-header">
                            <?= $user['pseudo'] ?> le <?= $commentaire['date_commentaire_fr'] ?>
                        </div>
                        <div class="card-body">
                            <blockquote class="blockquote mb-0">
                            <p class="mb-0"><?= $commentaire['commentaire'] ?></p>
                            </blockquote>
                        </div>
                    </div>
                    <?php } ?>
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
