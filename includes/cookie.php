<?php
if(!isset($_SESSION['id']) && isset($_COOKIE['idConnect'], $_COOKIE['password']) && !empty($_COOKIE['idConnect']) && !empty($_COOKIE['password']))
{
    $req = $bdd->prepare("SELECT * FROM membres WHERE pseudo = :pseudo OR mail = :mail");
    $req->execute(array(
        'pseudo' => $_COOKIE['idConnect'],
        'mail' => $_COOKIE['idConnect']));
    $resultat = $req->fetch();
    if($resultat)
    {
        if($_COOKIE['password'] === $resultat['password'])
        {
            $_SESSION['id'] = $resultat['id'];
            $_SESSION['pseudo'] = $resultat['pseudo'];
            $_SESSION['mail'] = $resultat['mail'];
            $_SESSION['admin'] = $resultat['admin'];
        }
    }
}
?>