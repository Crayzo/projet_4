<?php $title = "Signalements"; ?>
<?php ob_start(); ?>
<?php
$nbReports = $reqReports->rowCount();
if($nbReports > 0){
    while($reports = $reqReports->fetch()){ 
    /* MEMBERS */
    $reqUser = $userManager->selectUserId($reports['member_id']);
    $user = $reqUser->fetch();
    /* COMMENTS */
    $reqCommentaire = $commentManager->selectComment($reports['comment_id']);
    $comment = $reqCommentaire->fetch();
    /* COMMENT AUTHOR */
    $reqAuthor = $userManager->selectUserId($comment['author_id']);
    $commentAuthor = $reqAuthor->fetch();
?>
    <div class="container">
        <div class="card my-3">
            <div class="card-header mb-1">
                <p class="my-0"><b>Signalé par :</b> <?= $user['username'] ?></p>
                <p class="my-0"><b>Message :</b> <?= $reports['message'] ?></p>
            </div>
            <!-- Entête du commentaire -->
            <div class="card-header d-flex justify-content-between">
                <div class="align-self-center">
                    <strong><?= $commentAuthor['username'] ?></strong> le <?= $comment['comment_date_fr'] ?> 
                </div>
                <div class="d-flex flex-wrap justify-content-around report-buttons">
                    <a class="btn btn-outline-success btn-sm" href="index.php?action=reports&approve=<?= $reports['id'] ?>">Approuver</a>
                    <a class="btn btn-outline-danger btn-sm" href="index.php?action=reports&approve=<?= $reports['id'] ?>&delete=<?= $reports['comment_id']; ?>" onclick="return(confirm('Voulez-vous vraiment supprimer ce commentaire ?'));">Supprimer</a>
                </div>       
            </div>
            <!-- Corps du commentaire -->
            <div class="card-body">
                <blockquote class="blockquote mb-0">
                <p class="mb-0"><?= $comment['comment'] ?></p>
                </blockquote>
            </div>
        </div>
    </div>
<?php } $reqReports->closeCursor(); } else echo "<p class='text-center mt-3'>Aucun signalement à afficher.<br><a href='index.php'>Aller à l'accueil</a></p>"; ?>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>