<?php

$title = "Modifier un chapitre"; 
$tinyMce = true;
$hideFooter = true;

use Models\Functions;

ob_start() ?>

<div class="container mt-3">
    <?php Functions::flash(); ?>
    <form action="index.php?action=edit_chapter&id=<?= $id ?>" method="post">
        <div class="form-row">
            <div class="form-group col-12">
                <input type="text" class="form-control" name="title" value="<?= $data->getTitle(); ?>" required>
            </div>
        </div>
        <textarea name="content"><?= $data->getContent(); ?></textarea>
        <button type="submit" class="btn btn-dark w-100">Modifier</button>
    </form>
</div>

<?php 
$content = ob_get_clean();
require('template.php'); ?>