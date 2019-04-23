<?php
      // On récupère l'URL de la page pour ensuite affecter class = "active" aux liens de nav
      $page = $_SERVER['REQUEST_URI'];
      $page = str_replace("/projet_4/", "", $page);
?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark <?php if($page === 'index.php' || $page === ''){echo ' bg-transparent';} else echo ' bg-dark'; ?>">
    <a class="navbar-brand" href="#">Jean Forteroche</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php if($page === "index.php" || $page === ""){echo ' active';} ?>">
                <a class="nav-link" href="index.php"><i class="fa fa-home"></i> Accueil <span class="sr-only"></span></a>
            </li>
            <li class="nav-item  <?php if($page === "chapter.php?id=" . $_GET['id']){echo ' active';} ?>">
                <a class="nav-link" href="chapter.php?id=1"><i class="fa fa-book"></i> Chapitres</a>
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