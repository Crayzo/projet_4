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
                <?php while($data = $chapters->fetch()){ ?>
                    <div class="book col-12 col-sm-5 offset-sm-1 mx-auto text-center">
                        <h3><?= htmlspecialchars($data['title']); ?></h3>
                        <span>Ajouté le <?= htmlspecialchars($data['added_date_fr']) ?></span><br>
                        <span>Dernière modification le <?= htmlspecialchars($data['modification_date_fr']) ?></span>
                        <a href="index.php?action=chapter&id=<?= $data['id']; ?>" class="btn btn-outline-dark mt-3">Lire le chapitre</a>
                    </div>
                <?php } $chapters->closeCursor(); ?>
            </div> 
        </div>
    </section>
    <!-- Footer -->
</div> 
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>