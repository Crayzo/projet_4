<?php
    $title = "Accueil";
    $navTransparent = true;
?>
<?php ob_start(); ?>
<div id="main">
    <!-- NAVBAR -->
    <!-- SLIDER -->
    <section>
        <div class="slider">
            <div id="home-image">
                <img src="public/images/1.jpg" alt="Responsive image">
            </div>
            <div id="home-text">
                <h1>Billet simple pour l'Alaska</h1>
                <div class="divider div-white my-3"></div>
                <a href="index.php?action=chapters" class="btn btn-outline-light btn-lg mt-2">Voir les chapitres</a>
            </div>
        </div>
    </section>
    <!-- CHAPTERS -->
    <section class="chapters">
        <h2 class="text-center">Derniers chapitres</h2>
        <div class="divider div-black mb-4"></div>
        <div class="container">
            <div class="row">
                <?php while($data = $chapters->fetch())
                {
                ?>
                    <div class="book col-12 col-sm-5 offset-sm-1 mx-auto text-center">
                        <h3><?= htmlspecialchars($data['title']); ?></h3>
                        <span>Ajouté le <?= htmlspecialchars($data['added_date_fr']) ?></span><br>
                        <span>Dernière modification le <?= htmlspecialchars($data['modification_date_fr']) ?></span><br>
                        <a href="index.php?action=chapter&id=<?= $data['id']; ?>" class="btn btn-outline-dark mt-3">Lire le chapitre</a>
                    </div>
                <?php
                }
                $chapters->closeCursor();
                ?>
            </div> 
        </div>
    </section>
    <!-- FOOTER -->
</div> 
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>