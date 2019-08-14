<?php
$title = "Ajouter un chapitre"; 
$tinyMce = true;
$hideFooter = true;

use Models\Functions;

ob_start() ?>

<div class="container mt-3">
    <?php Functions::flash(); ?>
    <form action="index.php?action=new_chapter" method="post">
        <div class="form-row">
            <div class="form-group col-12">
                <input type="text" class="form-control" name="title" placeholder="Chapitre X" value="<?php if(isset($_POST['title'])){echo $_POST['title'];} ?>">
            </div>
        </div>
        <textarea name="content"><?php if(isset($_POST['content'])){echo $_POST['content'];} ?></textarea>
        <button type="submit" class="btn btn-dark w-100">Ajouter</button>
    </form>
</div>

<?php 
$content = ob_get_clean(); 
require('template.php'); ?>