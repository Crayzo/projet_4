<?php
session_start();
setcookie('idConnect', "", time()-3600);
setcookie('password', "", time()-3600);
$_SESSION = array();
session_destroy();
if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
    header("Location: " . $_SERVER["HTTP_REFERER"]);
else
    header("Location: index.php");
?>