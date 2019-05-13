<?php
session_start();
// Connexion à la base de données
try
{
	$bdd = new PDO('mysql:host=localhost;dbname=projet_4', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
}
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}
if(isset($_SESSION['id']))
{
    $getID = intval($_GET['id']);
    $commentaires = $bdd->prepare('SELECT * FROM commentaires WHERE id = ?');
    $commentaires->execute(array($getID));
    $commentaire = $commentaires->fetch();
    if($_SESSION['id'] === $commentaire['id_auteur'])
    {
        $delete = $bdd->prepare('DELETE FROM commentaires WHERE id = ?');
        $delete->execute(array($getID));
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    else
        echo "Une erreur est survenue";
}
?>