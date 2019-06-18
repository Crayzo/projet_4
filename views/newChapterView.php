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
                <input type="text" class="form-control" name="title" placeholder="Chapitre X" value="<?php if(isset($_POST['title']) && !isset($success)) {echo $_POST['title'];} ?>" required>
            </div>
        </div>
        <textarea name="content"><?php if(isset($_POST['content']) && !isset($success)){echo $_POST['content'];} ?></textarea>
        <?php if(isset($error)){ ?>
            <p class="text-danger mb-1"><?= $error ?></p>
        <?php } ?>
        <?php if(isset($success)){ ?>
            <p class="text-success mb-1"><?= $success ?></p>
        <?php } ?>
        <button type="submit" class="btn btn-dark">Ajouter</button>
    </form>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('template.php'); ?>