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
$getID = intval($_GET['id']);
if(isset($_SESSION['id'], $getID) && !empty($_SESSION['id']) && !empty($getID))
{
    $req = $bdd->prepare('SELECT * FROM signalements WHERE id_membre = ? AND id_commentaire = ?');
    $req->execute(array($_SESSION['id'], $getID));
    $reportExist = $req->rowCount();
    if(!$reportExist)
    {
        $insertReport = $bdd->prepare('INSERT INTO signalements SET id_membre = ?, id_commentaire = ?');
        $insertReport->execute(array($_SESSION['id'], $getID));
        echo "Le commentaire a été signalé";
    }
    else
        echo "Vous avez déjà signalé ce commentaire";
}
?>