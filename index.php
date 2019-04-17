<?php
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=projet_4', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}
// On récupère les 4 derniers chapitres
$req = $bdd->query('SELECT id, titre, contenu, DATE_FORMAT(date_ajout, \'%d/%m/%Y\') AS date_ajout_fr, DATE_FORMAT(date_modification, \'%d/%m/%Y\') AS date_modification_fr FROM book ORDER BY id DESC LIMIT 0, 4');
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
    <title>Jean Forteroche</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent">
        <a class="navbar-brand" href="#">Jean Forteroche</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#"><i class="fa fa-home"></i> Accueil <span class="sr-only"></span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa fa-book"></i> Chapitres</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fa fa-info-circle"></i> À propos</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link"><i class="fa fa-pen"></i> Inscription</a></li>
                <li class="nav-item"><a class="nav-link"><i class="fa fa-user"></i> Connexion</a></li>
            </ul>
        </div>
    </nav>
    <section>
       <div class="slider">
            <div id="slider-image">
                <img src="assets/img/1.jpg" alt="Responsive image">
            </div>
            <div id="slider-text">
                <h1>Billet simple pour l'Alaska</h1>
                <div class="white-divider"></div>
                <button class="btn btn-outline-light">Voir les chapitres</button>
            </div>
       </div>
    </section>
    <section id="chapter">
        <h2>Derniers chapitres</h2>
        <div class="grey-divider"></div>
        <div class="container">
            <div class="row">
                <?php while($donnees = $req->fetch())
                {
                ?>
                <div class="book col-12 col-sm-5 offset-sm-1 mx-auto text-center">
                    <h3><?= htmlspecialchars($donnees['titre']); ?></h3>
                    <span>Ajouté le <?= htmlspecialchars($donnees['date_ajout_fr']) ?></span><br>
                    <span>Dernière modification le <?= htmlspecialchars($donnees['date_modification_fr']) ?></span>
                    <p><?= nl2br(htmlspecialchars($donnees['contenu'])); ?></p>
                    <button type="button" class="btn btn-outline-dark">Lire le chapitre</button>
                </div>
                <?php
                }
                ?>
            </div> 
        </div>
    </section>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
  </body>
</html>