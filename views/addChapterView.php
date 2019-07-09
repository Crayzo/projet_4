<?php
    $title = "Ajouter un chapitre"; 
    $tinyMce = true;
    $hideFooter = true;
?>
<?php ob_start() ?>
<div class="container mt-3 text-right">
    <form action="index.php?action=new_chapter" method="post">
        <div class="form-row">
            <div class="form-group col-12">
                <input type="text" class="form-control" name="title" placeholder="Chapitre X" required>
            </div>
        </div>
        <textarea name="content"></textarea>
        <?php if(isset($error)){ ?>
            <p class="text-danger mb-1"><?= $error ?></p>
        <?php } ?>
        <button type="submit" class="btn btn-dark">Ajouter</button>
    </form>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>