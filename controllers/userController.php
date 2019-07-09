<?php

function login()
{
    if(isset($_SESSION['id']))
    {
        header("Location: index.php");
        exit();
    }
    
    if(!empty($_POST))
    {
        $userManager = new Project\Models\UserManager();
        $idConnect = htmlspecialchars($_POST['idConnect']);
        $validation = true;
        $member = $userManager->selectUser($idConnect);
        
        if(empty($idConnect) || empty($_POST['passwordConnect']))
        {
            $validation = false;
            $error = 'Tous les champs doivent être complétés !';
        }

        elseif(!$member)
        {
            $validation = false;
            $error = 'Mauvais identifiant !';
        }

        elseif(!password_verify($_POST['passwordConnect'], $member["password"]))
        {
            $validation = false;
            $error = 'Mauvais mot de passe !';
        }

        elseif($validation)
        {  
            if(isset($_POST['rememberMe']))
            {
                $passHash = password_hash($_POST['passwordConnect'], PASSWORD_DEFAULT);
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
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
    else
    {
        header('Location: index.php');
        exit();
    }
}
function register()
{
    if(isset($_SESSION['id']))
    {
        header("Location: index.php");
        exit();
    }

    if(!empty($_POST))
    {
        $userManager = new Project\Models\UserManager();
        $pseudo = htmlspecialchars($_POST['pseudo']);
        $mail = htmlspecialchars($_POST['mail']);
        $mail2 = htmlspecialchars($_POST['mail2']);
        $reqPseudo = $userManager->selectUserPseudo($pseudo);
        $reqMail = $userManager->selectUserMail($mail);
        $validation = true;

        if(empty($_POST['pseudo']) || empty($_POST['mail']) || empty($_POST['mail2']) || empty($_POST['password']) || empty($_POST['password2']))
        {
            $validation = false;
            $error = 'Tous les champs doivent être complétés !';
        }

        elseif(strlen($pseudo) >= 25)
        {
            $validation = false;
            $error = 'Votre pseudo ne doit pas dépasser 25 caractères.';
        }
                
        elseif($reqPseudo->rowCount() > 0)
        {
            $validation = false;
            $error = 'Le pseudo existe déjà !';
        }

        elseif($mail !== $mail2)
        {
            $validation = false;
            $error = 'Vos adresses mail ne correspondent pas !';
        }

        elseif(!filter_var($mail, FILTER_VALIDATE_EMAIL))
        {
            $validation = false;
            $error = 'Votre adresse mail n\'est pas valide.';
        }
                            
        elseif($reqMail->rowCount() > 0)
        {
            $validation = false;
            $error = 'Adresse mail déjà utilisée !';
        }

        elseif($_POST['password'] !== $_POST['password2'])
        {
            $validation = false;
            $error = 'Vos mots de passe ne correspondent pas';

        }

        elseif($validation)
        {
            $passHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $userManager->insertNewUser($pseudo, $mail, $passHash);
            $success = 'Votre compte a bien été créé !';
        }                          
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
        $validation = true;
        if(isset($_POST['newPseudo']) && !empty($_POST['newPseudo']) && $_POST['newPseudo'] !== $user['username'])
        {
            $newPseudo = htmlspecialchars($_POST['newPseudo']);
            $pseudoLength = strlen($newPseudo);
            $reqPseudo = $userManager->selectUserPseudo($newPseudo);

            if($pseudoLength >= 25)
            {
                $validation = false;
                $error = "Votre pseudo ne doit pas dépasser 25 caractères !";
            }
            
            elseif($reqPseudo->rowCount())
            {
                $validation = false;
                $error = "Le pseudo existe déjà !";
            }

            elseif($validation)
            {
                $userManager->updateUsername($newPseudo, $_SESSION['id']);
                $_SESSION['username'] = $newPseudo;
                $success = "Votre compte a bien été mis à jour";
            }
        }
        if(isset($_POST['newMail']) && !empty($_POST['newMail']) && $_POST['newMail'] !== $user['mail'])
        {
            $newMail = htmlspecialchars($_POST['newMail']);
            $reqMail = $userManager->selectUserMail($newMail);

            if(!filter_var($newMail, FILTER_VALIDATE_EMAIL))
            {
                $validation = false;
                $error = "Votre adresse mail n'est pas valide.";
            }

            elseif($reqMail->rowCount())
            {
                $validation = false;
                $error = "Adresse mail déjà utilisée !";
            }

            elseif($validation)
            {
                $userManager->updateMail($newMail, $_SESSION['id']);
                $_SESSION['mail'] = $newMail;
                $success = "Votre compte a bien été mis à jour";
            }       
        }
        if(isset($_POST['newPswd']) && !empty($_POST['newPswd']) && $_POST['newPswd'] !== $user['password'] && isset($_POST['newPswd2']) && !empty($_POST['newPswd2']) && $_POST['newPswd2'] !== $user['password'])
        {
            $pswd = password_hash($_POST['newPswd'], PASSWORD_DEFAULT);
            $pswd2 = $_POST['newPswd2'];
            $isPasswordCorrect = password_verify($pswd2, $pswd);
            $reqPswd = $userManager->selectUserPassword($_SESSION['id']);
            $data = $reqPswd->fetch();
            $pswdVerify = password_verify($pswd2, $data['password']);

            if(!$isPasswordCorrect)
            {
                $validation = false;
                $error = "Vos deux mots de passe ne correspondent pas !";
            }

            elseif($pswdVerify)
            {
                $validation = false;
                $error = "Veuillez saisir un mot de passe différent de votre mot de passe actuel !";
            }

            elseif($validation)
            {
                $userManager->updatePassword($pswd, $_SESSION['id']);
                $success = "Votre compte a bien été mis à jour";
            }
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
        {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        else
        {
            header('Location: index.php'); 
            exit();
        }
    }
    else
    {
        header('Location: index.php');   
        exit();
    }
}
function lightMode()
{
    if(isset($_SESSION['id']))
    {
        $userManager = new Project\Models\UserManager();
        $userManager->lightMode($_SESSION['id']);
        $_SESSION['dark'] = false;

        if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
        {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        }
        else
        {
            header('Location: index.php'); 
        }
    }
    else
    {
        header('Location: index.php');
        exit();
    }
}
function acceptCookie()
{
    setcookie('accept_cookie', true, time()+365*24*3600, null, null, false, true); 

    if(isset($_SERVER['HTTP_REFERER']) && !empty($_SERVER['HTTP_REFERER']))
    {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
    else
    {
        header("Location: index.php");
    }
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