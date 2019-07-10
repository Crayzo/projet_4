<div class="card mt-3" id='content'>
    <div class="card-header d-flex justify-content-between">
        <div class="align-self-center">
            <strong><?= $user->getUsername(); ?></strong> le <?= $data->getCommentDate(); ?> 
        </div>
        <?php if(isset($_SESSION['id']) && $_SESSION['id'] === $data->getAuthorId()){ ?>
                <a id="delete-comment" class="btn btn-outline-dark btn-sm" href="index.php?action=delete_comment&id=<?= $data->getId(); ?>">Supprimer</a>
            <?php } elseif(isset($_SESSION['id'] )){ ?>   
                <?php if(!$reportExist){ ?>
                    <button data-id="<?= $data->getId(); ?>" class="btn btn-outline-danger btn-sm" data-toggle="modal" data-target="#modal<?= $data->getId(); ?>">Signaler</button>
                <?php } elseif($reportExist){ ?>
                    <button type="button" class="btn btn-outline-danger btn-sm" disabled>Signalé</button>
                <?php } ?>
                <!-- MODAL -->
                <?php include 'views/modal.php' ?>
            <?php } ?>
    </div>
    <div class="card-body">
        <blockquote class="blockquote mb-0">
        <p class="mb-0"><?= $data->getComment(); ?></p>
        </blockquote>
    </div>
</div>
