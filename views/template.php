<!DOCTYPE html>
<html lang="fr" prefix="og: http://ogp.me/ns#">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta property="og:title" content="Jean Forteroche">
        <meta property="og:description" content="Billet simple pour l'Alaska">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://www.blog.cv-online.me/">
        <meta property="og:image" content="https://i.ibb.co/7RYkGpD/1.jpg">
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
            <link rel="stylesheet" href="public/css/light.css?t=<?= time() ?>">
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
        <script src="public/js/main.js?t=<?= time() ?>"></script>
    </body>
</html>