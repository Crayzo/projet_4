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
include_once 'includes/cookie.php';
// Si la variable id existe et qu'elle est supérieure à zéro
if(isset($_GET['id']) && $_GET['id'] > 0)
{
    // Récupération du chapitre
    $getID = intval($_GET['id']);
    $req = $bdd->prepare('SELECT id, titre, contenu FROM chapitres WHERE id = ?');
    $req->execute(array($getID));
    $donnees = $req->fetch();
    // Ajouter un commentaire : si il y a un clic sur le bouton submit
    if(isset($_POST['submit_commentaire']))
    {
        // On vérifie si les variables session et commentaire existent et ne sont pas vides
        if(isset($_SESSION['pseudo'], $_POST['commentaire']) && !empty($_SESSION['pseudo']) && !empty($_POST['commentaire']))
        {
            // On insére le commentaire
            $postCommentaire = htmlspecialchars($_POST['commentaire']);
            $insertCommentaire = $bdd->prepare('INSERT INTO commentaires (commentaire, id_chapitre, id_auteur, date_commentaire) VALUES (?, ?, ?, NOW())');
            $insertCommentaire->execute(array($postCommentaire, $getID, $_SESSION['id']));
            $success = "Votre commentaire a été envoyé avec succès";
        }
        else
            $message = "Vous devez écrire un commentaire avant d'envoyer !";
    }
    $commentaires = $bdd->prepare('SELECT *, DATE_FORMAT(date_commentaire, \'%d/%m/%Y à %H:%i:%s\') AS date_commentaire_fr FROM commentaires WHERE id_chapitre = ? ORDER BY id DESC');
    $commentaires->execute(array($getID));
    if(isset($_POST['submit_report']))
    {
        if(!empty($_POST))
        {
            if(isset($_SESSION['id'], $_GET['report']) && !empty($_POST['message_report']) && $_GET['report'] > 0)
            {

                $getReport = intval($_GET['report']);
                $reqReport = $bdd->prepare('SELECT * FROM signalements WHERE id_membre = ? AND id_commentaire = ?');
                $reqReport->execute(array($_SESSION['id'], $getReport));
                $reportExist = $reqReport->rowCount();
                if(!$reportExist)
                {
                    $postMessage = htmlspecialchars($_POST['message_report']);
                    $insertReport = $bdd->prepare('INSERT INTO signalements SET id_membre = ?, id_commentaire = ?, message = ?');
                    $insertReport->execute(array($_SESSION['id'], $getReport, $postMessage));
                }
                else
                    echo "Vous avez déjà signalé ce commentaire";
            }
        }
        header("Location: chapter.php?id=$getID");
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
    <!-- Si la variable id existe, on affiche le titre du chapitre sélectionné  -->
	<title><?php if(isset($donnees['id'])){echo $donnees['titre'];} else echo "Erreur";  ?></title>
  </head>
  <body>
    <!-- Si la variable id n'existe pas -->
  	<?php if(!isset($donnees['id'])){echo "Erreur : Ce chapitre n'existe pas.";} else { ?>
    <div id="main">
            <?php include 'includes/navbar.php'; ?>
            <!-- Chapitre -->
			<section id="chapter-text">
				<div>
					<h1 class="text-center mt-3"><?= $donnees['titre']; ?></h1>
					<div class="divider div-black mb-4"></div>
                    <p><?= $donnees['contenu']; ?></p>
                    <!-- Espace administration -->
                    <?php if(isset($_SESSION['id']) && $_SESSION['admin'] == true) { ?> 
                    <div class="text-center mb-4">
                        <a href="edit.php?id=<?= $donnees['id']; ?>" class="btn btn-dark mt-3">Modifier</a>
                        <a href="delete.php?id=<?= $donnees['id']; ?>" onclick="return(confirm('Voulez-vous vraiment supprimer ce chapitre ?'));" class="btn btn-dark mt-3">Supprimer</a>
                    </div>
                    <?php } ?>
				</div>
            </section>
            <!-- Espace commentaire -->
            <section>
                <div class="container mb-5">
                    <form method="post" class="mt-3">
                        <!-- Si le membre est connecté -->
                        <?php if(isset($_SESSION['id'])) { ?>
                        <h3 class="text-center mb-4">Ajouter un commentaire</h3>
                        <div class="form-row">
                            <div class="form-group col-12">
                                <textarea name="commentaire" class="form-control" placeholder="Votre commentaire"></textarea>
                            </div>
                        </div>
                        <?php if(isset($message)){ ?>
                        <p class="text-danger"><?= $message ?></p>
                        <?php } ?>
                        <?php if(isset($success)){ ?>
                        <p class="text-success"><?= $success ?></p>
                        <?php } ?>
                        <button type="submit" class="btn btn-outline-secondary w-100" name="submit_commentaire">Envoyer</button>
                        <!-- Sinon -->
                        <?php } else { ?> 
                        <p class="my-0">Vous devez être connecté(e) pour ajouter un commentaire !</p>
                        <a href="connexion.php">Se connecter</a>
                        <?php } ?>
                    </form>
                    <!-- Affichage des commentaires -->
                    <?php while($commentaire = $commentaires->fetch()) {
                        $reqUser = $bdd->prepare('SELECT pseudo FROM membres WHERE id = ?');
                        $reqUser->execute(array($commentaire['id_auteur']));
                        $user = $reqUser->fetch();

                        if(isset($_SESSION['id']))
                        {
                            $reqReport = $bdd->prepare('SELECT * FROM signalements WHERE id_membre = ? AND id_commentaire = ?');
                            $reqReport->execute(array($_SESSION['id'], $commentaire['id']));
                            $reportExist = $reqReport->rowCount();
                        }
                    ?>
                    <div class="card mt-3">
                        <!-- Entête du commentaire -->
                        <div class="card-header d-flex justify-content-between">
                            <div class="align-self-center">
                                <strong><?= $user['pseudo'] ?></strong> le <?= $commentaire['date_commentaire_fr'] ?> 
                            </div>
                            <!-- Si le membre est connecté et qu'il possède un commentaire -->
                            <?php if(isset($_SESSION['id']) && $_SESSION['id'] === $commentaire['id_auteur']){ ?>
                                <a class="btn btn-outline-dark btn-sm" href="delete_commentaire.php?id=<?= $commentaire['id']; ?>" onclick="return(confirm('Voulez-vous vraiment supprimer votre commentaire ?'));">Supprimer</a>
                                <!-- Sinon -->
                                <?php } elseif(isset($_SESSION['id'] )){ ?>   
                                <!-- Si le commentaire n'a pas été signalé par l'utilisateur -->
                                <?php if(!$reportExist){ ?>
                                <button data-id="<?= $commentaire['id'] ?>" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal">Signaler</button>
                                <!-- Si le commentaire a déjà été signalé -->
                                <?php } elseif($reportExist){ ?>
                                <button type="button" class="btn btn-outline-danger btn-sm" disabled>Signalé</button>
                                <?php } ?>
                                <!-- MODAL -->
                                <?php include 'includes/modal.php' ?>
                                <?php } ?>
                        </div>
                        <!-- Corps du commentaire -->
                        <div class="card-body">
                            <blockquote class="blockquote mb-0">
                            <p class="mb-0"><?= $commentaire['commentaire'] ?></p>
                            </blockquote>
                        </div>
                    </div>
                    <?php } $reqUser->closeCursor(); ?>
                </div>
            </section>
			<?php include 'includes/footer.php' ?>
			<?php } ?>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
    <script>
    $('#modal').on('show.bs.modal', function (event) 
    {
        var button = $(event.relatedTarget);
        var recipient = button.data('id'); 
        var modal = $(this);
        modal.find('#modal-form').attr('action', "chapter.php?id=<?= $getID ?>&report=" + recipient);
    })
    </script>
  </body>
</html>