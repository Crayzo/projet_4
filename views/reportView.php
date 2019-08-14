<?php 

$title = "Signalements";
ob_start();

if($reportExist)
{
    foreach($reports as $report)
    { 
        /* USERS */
        $user = $userManager->selectUserId($report->getMemberId());
        /* COMMENTS */
        $comment = $commentManager->selectComment($report);
        /* COMMENT AUTHOR */
        $author = $userManager->selectUserId($comment->getAuthorId()); ?>

        <div class="container">
            <div class="card my-3">
                <div class="card-header mb-1">
                    <p class="my-0"><b>Signalé par :</b> <?= $user->getUsername(); ?></p>
                    <p class="my-0"><b>Message :</b> <?= $report->getMessage(); ?></p>
                </div>
                <div class="card-header d-flex justify-content-between">
                    <div class="align-self-center">
                        <strong><?= $author->getUsername(); ?></strong> le <?= $comment->getCommentDate(); ?> 
                    </div>
                    <div class="d-flex flex-wrap justify-content-around report-buttons">
                        <a class="btn btn-outline-success btn-sm" href="index.php?action=reports&approve=<?= $report->getId(); ?>">Approuver</a>
                        <a class="btn btn-outline-danger btn-sm" href="index.php?action=reports&approve=<?= $report->getId(); ?>&delete=<?= $report->getCommentId(); ?>" onclick="return(confirm('Voulez-vous vraiment supprimer ce commentaire ?'));">Supprimer</a>
                    </div>       
                </div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p class="mb-0"><?= $comment->getComment(); ?></p>
                    </blockquote>
                </div>
            </div>
        </div>
<?php  } 
} 
else echo "<p class='text-center mt-3'>Aucun signalement à afficher.<br><a href='index.php'>Aller à l'accueil</a></p>";

$content = ob_get_clean();
require('template.php'); ?>