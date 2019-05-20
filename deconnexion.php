<?php
session_start();
setcookie('idConnect', "", time()-3600);
setcookie('password', "", time()-3600);
$_SESSION = array();
session_destroy();
header("Location: " . $_SERVER["HTTP_REFERER"]);
?>