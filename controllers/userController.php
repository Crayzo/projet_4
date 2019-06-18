<?php
require_once('models/UserManager.php');

function login()
{
    if(isset($_SESSION['id']))
        header("Location: index.php");
    if(!empty($_POST))
    {
        $userManager = new Project\Models\UserManager();
        $idConnect = htmlspecialchars($_POST['idConnect']);
        $passwordConnect = $_POST['passwordConnect'];
        if(!empty($idConnect) && !empty($passwordConnect))
        {
            $member = $userManager->selectUser($idConnect);
            $isPasswordCorrect = password_verify($passwordConnect, $member["password"]);
            if($member)
            {
                if($isPasswordCorrect)
                {
                    if(isset($_POST['rememberMe']))
                    {
                        $passHash = password_hash($passwordConnect, PASSWORD_DEFAULT);
                        setcookie('idConnect', $idConnect, time()+365*24*3600, null, null, false, true);
                        setcookie('password', $member['password'], time()+365*24*3600, null, null, false, true);
                    }
                    $_SESSION['id'] = $member['id'];
                    $_SESSION['username'] = $member['username'];
                    $_SESSION['mail'] = $member['mail'];
                    $_SESSION['admin'] = $member['admin'];
                    $_SESSION['dark'] = $member['dark'];
                    header('Location: index.php');
                }
                else
                    $error = 'Mauvais mot de passe !';
            }
            else
                $error = 'Mauvais identifiant !';
        }
        else
            $error = 'Tous les champs doivent être complétés !';
    }
    require('views/loginView.php');
}
function logout()
{
    session_start();
    setcookie('idConnect', "", time()-3600);
    setcookie('password', "", time()-3600);
    $_SESSION = array();
    session_destroy();
    if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    else
        header('Location: index.php');
}
function register()
{
    if(isset($_SESSION['id']))
        header("Location: index.php");
    if(!empty($_POST))
    {
        $userManager = new Project\Models\UserManager();
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mail = htmlspecialchars($_POST['mail']);
        $mail2 = htmlspecialchars($_POST['mail2']);
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        if(!empty($_POST['pseudo']) && !empty($_POST['mail']) && !empty($_POST['mail2']) && !empty($_POST['password']) && !empty($_POST['password2']))
        {
            $pseudoLength = strlen($pseudo);
            if($pseudoLength <= 25)
            {
                $reqPseudo = $userManager->selectUserPseudo($pseudo);
                $pseudoExist = $reqPseudo->rowCount();
                if($pseudoExist === 0)
                {
                    if($mail === $mail2)
                    {
                        if(filter_var($mail, FILTER_VALIDATE_EMAIL))
                        {
                            $reqMail = $userManager->selectUserMail($mail);
                            $mailExist = $reqMail->rowCount();
                            if($mailExist === 0)
                            {
                                if($password === $password2)
                                {
                                    $passHash = password_hash($password, PASSWORD_DEFAULT);
                                    $userManager->insertNewUser($pseudo, $mail, $passHash);
                                    $success = 'Votre compte a bien été créé !';
                                }
                                else
                                    $error = 'Vos mots de passe ne correspondent pas';
                            }
                            else
                                $error = 'Adresse mail déjà utilisée !';
                        }
                        else
                            $error = 'Votre adresse mail n\'est pas valide.';
                    }
                    else
                        $error = 'Vos adresses mail ne correspondent pas !';
                }
                else
                    $error = 'Le pseudo existe déjà !';
            }
            else
                $error = 'Votre pseudo ne doit pas dépasser 25 caractères.';
        }
        else
            $error = 'Tous les champs doivent être complétés !';
    }
    require('views/registerView.php');
}
function getProfile()
{
    if(isset($_SESSION['id']))
    {
        $userManager = new Project\Models\UserManager();
        $req = $userManager->selectUserId($_SESSION['id']);
        $user = $req->fetch();
        if(isset($_POST['newPseudo']) && !empty($_POST['newPseudo']) && $_POST['newPseudo'] !== $user['username'])
        {
            $newPseudo = htmlspecialchars($_POST['newPseudo']);
            $pseudoLength = strlen($newPseudo);
            if($pseudoLength <= 25)
            {
                $reqPseudo = $userManager->selectUserPseudo($newPseudo);
                $pseudoExist = $reqPseudo->rowCount();
                if(!$pseudoExist)
                {
                    $userManager->updateUsername($newPseudo, $_SESSION['id']);
                    $_SESSION['username'] = $newPseudo;
                    $success = "Votre compte a bien été mis à jour";
                }
                else
                    $error = "Le pseudo existe déjà !";
            }
            else
                $error = "Votre pseudo ne doit pas dépasser 25 caractères !";
        }
        if(isset($_POST['newMail']) && !empty($_POST['newMail']) && $_POST['newMail'] !== $user['mail'])
        {
            $newMail = htmlspecialchars($_POST['newMail']);
            if(filter_var($newMail, FILTER_VALIDATE_EMAIL))
            {
                $reqMail = $userManager->selectUserMail($newMail);
                $mailExist = $reqMail->rowCount();
                if($mailExist === 0)
                {
                    $userManager->updateMail($newMail, $_SESSION['id']);
                    $_SESSION['mail'] = $newMail;
                    $success = "Votre compte a bien été mis à jour";
                }
                else
                    $error = "Adresse mail déjà utilisée !";
            }
            else 
                $error = "Votre adresse mail n'est pas valide.";
        }
        if(isset($_POST['newPswd']) && !empty($_POST['newPswd']) && $_POST['newPswd'] !== $user['password'] && isset($_POST['newPswd2']) && !empty($_POST['newPswd2']) && $_POST['newPswd2'] !== $user['password'])
        {
            $pswd = password_hash($_POST['newPswd'], PASSWORD_DEFAULT);
            $pswd2 = $_POST['newPswd2'];
            $isPasswordCorrect = password_verify($pswd2, $pswd);
            if($isPasswordCorrect)
            {
                $reqPswd = $userManager->selectUserPassword($_SESSION['id']);
                $data = $reqPswd->fetch();
                $pswdVerify = password_verify($pswd2, $data['password']);
                if($pswdVerify === false)
                {
                    $userManager->updatePassword($pswd, $_SESSION['id']);
                    $success = "Votre compte a bien été mis à jour";
                }
                else
                    $error = "Veuillez saisir un mot de passe différent de votre mot de passe actuel !";
            }
            else
                $error = "Vos deux mots de passe ne correspondent pas !";
        }
        require('views/profileView.php');
    }
    else
        header('Location: index.php');
}
function darkMode()
{
    if(isset($_SESSION['id']))
    {
        $userManager = new Project\Models\UserManager();
        $userManager->darkMode($_SESSION['id']);
        $_SESSION['dark'] = true;
        if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        else
            header('Location: index.php'); 
    }
    else
        header('Location: index.php');   
}
function lightMode()
{
    if(isset($_SESSION['id']))
    {
        $userManager = new Project\Models\UserManager();
        $userManager->lightMode($_SESSION['id']);
        $_SESSION['dark'] = false;
        if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        else
            header('Location: index.php'); 
    }
    else
        header('Location: index.php');
}
function acceptCookie()
{
    setcookie('accept_cookie', true, time()+365*24*3600, null, null, false, true); 
    if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    else
        header("Location: index.php");
}
function cookieConnect()
{
    if(!isset($_SESSION['id']) && isset($_COOKIE['idConnect'], $_COOKIE['password']) && !empty($_COOKIE['idConnect']) && !empty($_COOKIE['password']))
    {
        $userManager = new Project\Models\UserManager();
        $data = $userManager->selectUser($_COOKIE['idConnect']);
        if($data)
        {
            if($_COOKIE['password'] === $data['password'])
            {
                $_SESSION['id'] = $data['id'];
                $_SESSION['username'] = $data['username'];
                $_SESSION['mail'] = $data['mail'];
                $_SESSION['admin'] = $data['admin'];
                $_SESSION['dark'] = $data['dark'];
            }
        }
    }
}