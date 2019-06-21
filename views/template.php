<!DOCTYPE html>
<html lang="fr" xmlns:og="http://ogp.me/ns#">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Favicon -->
        <link rel="icon" type="image/png" href="public/images/favicon.gif">
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
        <!-- CSS -->
        <?php if(isset($_SESSION['dark']) && $_SESSION['dark'] == true){ ?>
            <link rel="stylesheet" href="public/css/dark.css?t=<?= time() ?>">
        <?php } else { ?>
            <link rel="stylesheet" href="public/css/style.css?t=<?= time() ?>">
        <?php } ?>
        <!-- Font Family -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet">
        <title><?= $title ?></title>
    </head>
    <body>
        <?php include('public/includes/navbar.php') ?>
        <?= $content ?>
        <?php if(!isset($hideFooter)){include('public/includes/footer.php');}  ?>
        <!-- Optional JavaScript -->
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <?php if(isset($tinyMce) && $tinyMce === true){ ?>
            <script src="https://cloud.tinymce.com/5/tinymce.min.js?apiKey=0ymxvkk8uy5skowdciteng030bzu94w3024imvbtq9xgrrqz"></script>
            <script>tinymce.init({selector: "textarea",});</script>
        <?php } ?>
        <script src="public/js/script.js?t=<?= time() ?>"></script>
        <?php if(isset($modal) && $modal === true){ ?>
            <script>
                $('#modal').on('show.bs.modal', function (event) 
                {
                    var button = $(event.relatedTarget);
                    var recipient = button.data('id'); 
                    var modal = $(this);
                    modal.find('#modal-form').attr('action', "index.php?action=chapter&id=<?= $getId ?>&report=" + recipient);
                })
            </script>
        <?php } ?>
    </body>
</html>