<?php
    $title = "Blog de Jean Forteroche";
    $navTransparent = true;
?>
<?php ob_start(); ?>
<div id="main">
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
                <?php foreach($chapters as $data)
                {
                ?>
                    <div class="book col-12 col-sm-5 offset-sm-1 mx-auto text-center">
                        <h3><?= $data->getTitle(); ?></h3>
                        <span>Ajouté le <?= $data->getAddedDate(); ?></span><br>
                        <span>Dernière modification le <?= $data->getModificationDate(); ?></span><br>
                        <a href="index.php?action=chapter&id=<?= $data->getId(); ?>" class="btn btn-outline-dark mt-3">Lire le chapitre</a>
                    </div>
                <?php
                }
                ?>
            </div> 
        </div>
    </section>
    <!-- FOOTER -->
</div> 
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>