<?php
    $title = "Modifier un chapitre"; 
    $tinyMce = true;
    $hideFooter = true;
?>
<?php ob_start() ?>
<div class="container mt-3 text-right">
    <form action="index.php?action=edit_chapter&id=<?= $getId ?>" method="post">
        <div class="form-row">
            <div class="form-group col-12">
                <input type="text" class="form-control" name="title" value="<?= $data['title'] ?>" required>
            </div>
        </div>
        <textarea name="content"><?= $data['content'] ?></textarea>
        <?php if(isset($error)){ ?>
            <p class="text-danger mb-1"><?= $error ?></p>
        <?php } ?>
        <?php if(isset($success)){ ?>
            <p class="text-success mb-1"><?= $success ?></p>
        <?php } ?>
        <button type="submit" class="btn btn-dark">Modifier</button>
    </form>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>