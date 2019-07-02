<div class="card mt-3" id='content'>
    <div class="card-header d-flex justify-content-between">
        <div class="align-self-center">
            <strong><?= $user['username'] ?></strong> le <?= $comment['comment_date_fr'] ?> 
        </div>
        <?php if(isset($_SESSION['id']) && $_SESSION['id'] === $comment['author_id']){ ?>
                <a id="delete-comment" class="btn btn-outline-dark btn-sm" href="index.php?action=delete_comment&id=<?= $comment['id']; ?>">Supprimer</a>
            <?php } elseif(isset($_SESSION['id'] )){ ?>   
                <?php if(!$reportExist){ ?>
                    <button data-id="<?= $comment['id'] ?>" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal<?= $comment['id'] ?>">Signaler</button>
                <?php } elseif($reportExist){ ?>
                    <button type="button" class="btn btn-outline-danger btn-sm" disabled>Signalé</button>
                <?php } ?>
                <!-- MODAL -->
                <?php include 'public/includes/modal.php' ?>
            <?php } ?>
    </div>
    <div class="card-body">
        <blockquote class="blockquote mb-0">
        <p class="mb-0"><?= $comment['comment'] ?></p>
        </blockquote>
    </div>
</div>
