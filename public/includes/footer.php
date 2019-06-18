<footer class="text-center">
    <div>
        <a id="scroll-top"><span class="fa fa-chevron-up text-white"></span></a>
        <h5 class="mb-0">© Tous droits réservés.</h5>
        <?php if(isset($_SESSION['dark']) && $_SESSION['dark'] == false){ ?>
            <a class="text-light text-decoration-none" href="index.php?action=dark_mode"><i class="fas fa-moon"></i> Mode nuit</a>
        <?php } elseif(isset($_SESSION['dark']) && $_SESSION['dark'] == true){ ?>
            <a class="text-light text-decoration-none" href="index.php?action=light_mode"><i class="fas fa-lightbulb"></i> Mode jour</a>
        <?php } ?>
    </div>
</footer>