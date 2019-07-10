<?php
    $title = "Chapitres";
?>
<?php ob_start(); ?>
<div id="main">
    <!-- Chapters -->
    <section class="chapters">
        <h2 class="text-center">Tous les chapitres</h2>
        <div class="divider div-black mb-5"></div>
        <?php if(isset($_SESSION['id']) && $_SESSION['admin'] == 1){ ?>
            <div class="d-flex justify-content-md-end justify-content-center mb-4">
                <a href="index.php?action=new_chapter" class="btn btn-dark add-btn">Ajouter un chapitre</a>
            </div>
        <?php } ?>
        <div class="container">
            <div class="row">
                <?php foreach($chapters as $data){ ?>
                    <div class="book col-12 col-sm-5 offset-sm-1 mx-auto text-center">
                        <h3><?= htmlspecialchars($data->getTitle()); ?></h3>
                        <span>Ajouté le <?= htmlspecialchars($data->getAddedDate()) ?></span><br>
                        <span>Dernière modification le <?= htmlspecialchars($data->getModificationDate()) ?></span>
                        <a href="index.php?action=chapter&id=<?= $data->getId(); ?>" class="btn btn-outline-dark mt-3">Lire le chapitre</a>
                    </div>
                <?php } ?>
            </div> 
        </div>
    </section>
    <!-- Footer -->
</div> 
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>