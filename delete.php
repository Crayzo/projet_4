<?php
session_start();
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=projet_4', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}
if(isset($_SESSION['id']) && $_SESSION['admin'] == 1)
{
    if(isset($_GET['id']) && $_GET['id'] > 0)
    {
        $getID = intval($_GET['id']);
        $reqChapitre = $bdd->prepare('DELETE FROM chapitres WHERE id = ?');
        $reqChapitre->execute(array($getID));
        $reqCommentaire = $bdd->prepare('DELETE FROM commentaires WHERE id_chapitre = ?');
        $reqCommentaire->execute(array($getID));
        header("Location: chapters.php");
    }
}
?>