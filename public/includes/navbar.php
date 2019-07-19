<?php

if(isset($_COOKIE['accept_cookie']))
{
    $showCookie = false;    
}
else
{
    $showCookie = true;
}
?>

<?php if($showCookie){ ?>
    <div class="alert alert-light alert-dismissible fade show mb-0 align-items-center rounded-0 p-1 flex-column fixed-bottom text-center" role="alert">
        <p class='my-0'>En poursuivant votre navigation, vous <b>acceptez</b> l’utilisation de <b>cookies</b> pour vous offrir une meilleure expérience utilisateur.</p>
        <a class="btn btn-secondary my-1 btn-sm align-self-center" href="index.php?action=accept_cookie">Accepter</a>
    </div>
<?php } ?>
<nav class="navbar navbar-expand-lg navbar-dark <?php if(isset($navTransparent) && $navTransparent === true){echo ' bg-transparent';} else echo ' bg-dark'; ?>">
    <a class="navbar-brand" href="index.php">Jean Forteroche</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item <?php if(isset($title) && $title === "Blog de Jean Forteroche"){echo ' active';} ?>">
                <a class="nav-link" href="index.php"><i class="fa fa-home"></i> Accueil <span class="sr-only"></span></a>
            </li>
            <li class="nav-item  <?php if(isset($title) && $title === "Chapitres" || isset($chapterPage) && $chapterPage === true){echo ' active';} ?>">
                <a class="nav-link" href="index.php?action=chapters"><i class="fa fa-book"></i> Chapitres</a>
            </li>
        </ul>
        <ul class="navbar-nav">
            <?php if(isset($_SESSION['id'])){ ?>
                <?php if(isset($_SESSION['admin']) && $_SESSION['admin'] == true){ ?>
                    <li class="nav-item <?php if(isset($title) && $title === "Signalements"){echo ' active';} ?>"><a class="nav-link" href="index.php?action=reports"><i class="fa fa-exclamation-circle"></i> Signalements</a></li>  
                <?php } ?>
                    <li class="nav-item <?php if(isset($title) && $title === "Édition du profil"){echo ' active';} ?>"><a class="nav-link" href="index.php?action=edit_profile"><i class="fa fa-user-circle"></i> <?= $_SESSION['username'] ?></a></li>
                    <li class="nav-item <?php if(isset($title) && $title === "Déconnexion"){echo ' active';} ?>"><a class="nav-link" href="index.php?action=logout"><i class="fa fa-sign-out-alt"></i> Déconnexion</a></li>
            <?php } else { ?>
                <li class="nav-item <?php if(isset($title) && $title === "Inscription"){echo ' active';} ?>"><a class="nav-link" href="index.php?action=register"><i class="fa fa-pen"></i> Inscription</a></li>
                <li class="nav-item <?php if(isset($title) && $title === "Connexion"){echo ' active';} ?>"><a class="nav-link" href="index.php?action=login"><i class="fa fa-user"></i> Connexion</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>