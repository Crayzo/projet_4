<?php
      // On récupère l'URL de la page pour ensuite affecter class = "active" aux liens de nav
      $page = $_SERVER['REQUEST_URI'];
      $page = str_replace("/projet_4/", "", $page);
?>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark <?php if($page === 'index.php' || $page === ''){echo ' bg-transparent';} else echo ' bg-dark'; ?>">
    <a class="navbar-brand" href="index.php">Jean Forteroche</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php if($page === "index.php" || $page === ""){echo ' active';} ?>">
                <a class="nav-link" href="index.php"><i class="fa fa-home"></i> Accueil <span class="sr-only"></span></a>
            </li>
            <li class="nav-item  <?php if($page === "chapters.php"){echo ' active';} ?>">
                <a class="nav-link" href="chapters.php"><i class="fa fa-book"></i> Chapitres</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"><i class="fa fa-info-circle"></i> À propos</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <?php if(isset($_SESSION['id'])){ ?>
             <li class="nav-item <?php if($page === "edition_profil.php"){echo ' active';} ?>"><a class="nav-link" href="edition_profil.php"><i class="fa fa-user-circle"></i> <?= $_SESSION['pseudo'] ?></a></li>
             <li class="nav-item <?php if($page === "deconnexion.php"){echo ' active';} ?>"><a class="nav-link" href="deconnexion.php"><i class="fa fa-sign-out-alt"></i> Déconnexion</a></li>
            <?php } else { ?>
            <li class="nav-item <?php if($page === "inscription.php"){echo ' active';} ?>"><a class="nav-link" href="inscription.php"><i class="fa fa-pen"></i> Inscription</a></li>
            <li class="nav-item <?php if($page === "connexion.php"){echo ' active';} ?>"><a class="nav-link" href="connexion.php"><i class="fa fa-user"></i> Connexion</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>