<?php
    $title = $chapter['title'];
    $modal = true; 
    $chapterPage = true;
?>
<?php ob_start(); ?>
<div id="main">
    <!-- CHAPTER -->
    <section id="chapter-text">
        <div>
            <h1 class="text-center mt-3"><?= $chapter['title']; ?></h1>
            <div class="divider div-black mb-4"></div>
            <p><?= $chapter['content']; ?></p>
            <!-- ADMIN -->
            <?php if(isset($_SESSION['id']) && $_SESSION['admin'] == true) { ?> 
            <div class="text-center mb-4">
                <a href="index.php?action=edit_chapter&id=<?= $chapter['id']; ?>" class="btn btn-dark mt-3">Modifier</a>
                <a href="index.php?action=delete_chapter&id=<?= $chapter['id']; ?>" onclick="return(confirm('Voulez-vous vraiment supprimer ce chapitre ?'));" class="btn btn-dark mt-3">Supprimer</a>
            </div>
            <?php } ?>
        </div>
    </section>
    <!-- COMMENT AREA -->
    <section>
        <div class="container mb-5">
            <form method="post" class="mt-3">
                <!-- Si le membre est connecté -->
                <?php if(isset($_SESSION['id'])) { ?>
                    <h3 class="text-center mb-4">Ajouter un commentaire</h3>
                    <div class="form-row">
                        <div class="form-group col-12">
                            <textarea name="comment" class="form-control" placeholder="Votre commentaire"></textarea>
                        </div>
                    </div>
                    <?php if(isset($message)){ ?>
                        <p class="text-danger"><?= $message ?></p>
                    <?php } ?>
                    <?php if(isset($success)){ ?>
                        <p class="text-success"><?= $success ?></p>
                    <?php } ?>
                        <button type="submit" class="btn btn-outline-secondary w-100" name="submit_comment">Envoyer</button>
                <!-- Sinon -->
                <?php } else { ?> 
                    <p class="my-0">Vous devez être connecté(e) pour ajouter un commentaire !</p>
                    <a href="index.php?action=login">Se connecter</a>
                <?php } ?>
            </form>
            <?php while($comment = $comments->fetch()){
                $users = $commentManager->selectAuthor($comment['author_id']);
                $user = $users->fetch();
                if(isset($_SESSION['id']))
                {
                    $report = $commentManager->selectReports($_SESSION['id'], $comment['id']);
                    $reportExist = $report->rowCount();
                }
                require('views/commentsView.php');
            } ?>
        </div>
    </section>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>