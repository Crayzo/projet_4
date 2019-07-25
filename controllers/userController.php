<?php
namespace Controllers;
use Models\Functions;
use Models\UserManager;
use Models\Users;

class UserController
{
    function login()
    {
        if(isset($_SESSION['id']))
        {
            header("Location: index.php");
            exit();
        }
        
        if(!empty($_POST))
        {
            $userManager = new UserManager();
            
            $idConnect = Functions::check($_POST['idConnect']);
            $validation = true;
            $member = $userManager->selectUser($idConnect);
    
            if(empty($idConnect) || empty($_POST['passwordConnect']))
            {
                $validation = false;
                Functions::setFlash('Tous les champs doivent être complétés !');
            }
    
            elseif(!$member)
            {
                $validation = false;
                Functions::setFlash('Mauvais identifiant !');
            }
    
            elseif(!password_verify($_POST['passwordConnect'], $member->getPassword()))
            {
                $validation = false;
                Functions::setFlash('Mauvais mot de passe !');
            }
    
            elseif($validation)
            {  
                if(isset($_POST['rememberMe']))
                {
                    $passHash = password_hash($_POST['passwordConnect'], PASSWORD_DEFAULT);
                    setcookie('idConnect', $idConnect, time()+365*24*3600, null, null, false, true);
                    setcookie('password', $member->getPassword(), time()+365*24*3600, null, null, false, true);
                }
    
                $_SESSION['id'] = $member->getId();
                $_SESSION['username'] = $member->getUsername();
                $_SESSION['mail'] = $member->getMail();
                $_SESSION['admin'] = $member->getAdmin();
                $_SESSION['dark'] = $member->getDark();
                header('Location: index.php');
                exit();
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
            $userManager = new UserManager();
    
            $pseudo = Functions::check($_POST['pseudo']);
            $mail = Functions::check($_POST['mail']);
            $mail2 = Functions::check($_POST['mail2']);
    
            $countPseudo = $userManager->countUserPseudo($pseudo);
            $countMail = $userManager->countUserMail($mail);
            $validation = true;
    
            if(empty($_POST['pseudo']) || empty($_POST['mail']) || empty($_POST['mail2']) || empty($_POST['password']) || empty($_POST['password2']))
            {
                $validation = false;
                Functions::setFlash('Tous les champs doivent être complétés !');
            }
    
            elseif(strlen($pseudo) > 25)
            {
                $validation = false;
                Functions::setFlash('Votre pseudo ne doit pas dépasser 25 caractères.');
            }
                    
            elseif($countPseudo > 0)
            {
                $validation = false;
                Functions::setFlash('Le pseudo existe déjà !');
            }
    
            elseif($mail !== $mail2)
            {
                $validation = false;
                Functions::setFlash('Vos adresses mail ne correspondent pas !');
            }
    
            elseif(!filter_var($mail, FILTER_VALIDATE_EMAIL))
            {
                $validation = false;
                Functions::setFlash('Votre adresse mail n\'est pas valide.');
            }
                                
            elseif($countMail > 0)
            {
                $validation = false;
                Functions::setFlash('Adresse mail déjà utilisée !');
            }
    
            elseif($_POST['password'] !== $_POST['password2'])
            {
                $validation = false;
                Functions::setFlash('Vos mots de passe ne correspondent pas');
            }
    
            elseif($validation)
            {
                $passHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
                $user = new Users([
                    'username' => $pseudo,
                    'mail' => $mail,
                    'password' => $passHash
                ]);
    
                $userManager->insertNewUser($user);
                Functions::setFlash("Votre compte a été créé avec succès ! <a href='index.php?action=login' class='alert-link'>Se connecter</a>", "success");
                header('Location: index.php?action=register');
                exit();
            }
        }
        require('views/registerView.php');
    }
    function getProfile()
    {
        if(isset($_SESSION['id']))
        {
            $userManager = new UserManager();
    
            $user = $userManager->selectUserId($_SESSION['id']);
            $validation = true;
    
            if(isset($_POST['newPseudo']) && !empty($_POST['newPseudo']) && $_POST['newPseudo'] !== $user->getUsername())
            {
                $newPseudo = Functions::check($_POST['newPseudo']);
                $pseudoLength = strlen($_POST['newPseudo']);
                $countUsername = $userManager->countUsername($newPseudo);
    
                if($pseudoLength >= 25)
                {
                    $validation = false;
                    Functions::setFlash("Votre pseudo ne doit pas dépasser 25 caractères !");
                }
                
                elseif($countUsername)
                {
                    $validation = false;
                    Functions::setFlash("Le pseudo existe déjà !");
                }
    
                elseif($validation)
                {
                    $user->setUsername($newPseudo);
                    $userManager->updateUsername($user);
                    $_SESSION['username'] = $user->getUsername();
                    Functions::setFlash("Votre compte a bien été mis à jour", "success");
                    header('Location: index.php?action=edit_profile');
                    exit();
                }
            }
    
            if(isset($_POST['newMail']) && !empty($_POST['newMail']) && $_POST['newMail'] !== $user->getMail())
            {
                $newMail = Functions::check($_POST['newMail']);
                $countMail = $userManager->countUserMail($newMail);
    
                if(!filter_var($newMail, FILTER_VALIDATE_EMAIL))
                {
                    $validation = false;
                    Functions::setFlash("Votre adresse mail n'est pas valide.");
                }
    
                elseif($countMail)
                {
                    $validation = false;
                    Functions::setFlash("Adresse mail déjà utilisée !");
                }
    
                elseif($validation)
                {
                    $user->setMail($newMail);
                    $userManager->updateMail($user);
                    $_SESSION['mail'] = $user->getMail();
                    Functions::setFlash("Votre compte a bien été mis à jour", "success");
                    header('Location: index.php?action=edit_profile');
                    exit();
                }
            }
    
            if(isset($_POST['newPswd']) && !empty($_POST['newPswd']) && $_POST['newPswd'] !== $user->getPassword() && isset($_POST['newPswd2']) && !empty($_POST['newPswd2']) && $_POST['newPswd2'] !== $user->getPassword())
            {
                $pswd = password_hash($_POST['newPswd'], PASSWORD_DEFAULT);
                $pswd2 = $_POST['newPswd2'];
                $isPasswordCorrect = password_verify($pswd2, $pswd);
    
                $data = $userManager->selectUserPassword($user);
                $pswdVerify = password_verify($pswd2, $data->getPassword());
    
                if(!$isPasswordCorrect)
                {
                    $validation = false;
                    Functions::setFlash("Vos deux mots de passe ne correspondent pas !");
                }
    
                elseif($pswdVerify)
                {
                    $validation = false;
                    Functions::setFlash("Veuillez saisir un mot de passe différent de votre mot de passe actuel !");
                }
    
                elseif($validation)
                {
                    $user->setPassword($pswd);
                    $userManager->updatePassword($user);
                    Functions::setFlash("Votre compte a bien été mis à jour", "success");
                    header('Location: index.php?action=edit_profile');
                    exit();
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
            $userManager = new UserManager();
    
            $user = $userManager->selectUserId($_SESSION['id']);
            $userManager->darkMode($user);
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
            $userManager = new UserManager();
    
            $user = $userManager->selectUserId($_SESSION['id']);
            $userManager->lightMode($user);
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
            $userManager = new UserManager();
            $user = $userManager->selectUser($_COOKIE['idConnect']);
            
            if($user)
            {
                if($_COOKIE['password'] === $user->getPassword())
                {
                    $_SESSION['id'] = $user->getId();
                    $_SESSION['username'] = $user->getUsername();
                    $_SESSION['mail'] = $user->getMail();
                    $_SESSION['admin'] = $user->getAdmin();
                    $_SESSION['dark'] = $user->getDark();
                }
            }
        }
    }
}