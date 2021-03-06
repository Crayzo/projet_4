<?php

namespace Controllers;

use Models\Functions;
use Models\UserManager;
use Models\Users;

class UserController
{
    /**
     * user login
     */
    function login($post, $idConnect, $passwordConnect, $rememberMe)
    {
        if(isset($_SESSION['id']))
        {
            header("Location: index.php");
            exit();
        }
        
        if($post)
        {
            $userManager = new UserManager();
            
            $idConnect = Functions::check($idConnect);
            $validation = true;
            $member = $userManager->selectUser($idConnect);
    
            if(empty($idConnect) || empty($passwordConnect))
            {
                $validation = false;
                Functions::setFlash('Tous les champs doivent être complétés !');
            }
    
            elseif(!$member)
            {
                $validation = false;
                Functions::setFlash('Mauvais identifiant !');
            }
    
            elseif(!password_verify($passwordConnect, $member->getPassword()))
            {
                $validation = false;
                Functions::setFlash('Mauvais mot de passe !');
            }
    
            elseif($validation)
            {  
                if($rememberMe)
                {
                    $passHash = password_hash($passwordConnect, PASSWORD_BCRYPT);
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

    /**
     * delete all cookies and session
     */
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

    /**
     * user registration
     */
    function register($post, $pseudo, $mail, $mail2, $password, $password2)
    {
        if(isset($_SESSION['id']))
        {
            header("Location: index.php");
            exit();
        }
    
        if($post)
        {
            $userManager = new UserManager();
    
            $pseudo = Functions::check($pseudo);
            $mail = Functions::check($mail);
            $mail2 = Functions::check($mail2);
    
            $countPseudo = $userManager->countUserPseudo($pseudo);
            $countMail = $userManager->countUserMail($mail);

            $validation = true;
    
            if(empty($pseudo) || empty($mail) || empty($mail2) || empty($password) || empty($password2))
            {
                $validation = false;
                Functions::setFlash('Tous les champs doivent être complétés !');
            }
    
            elseif(strlen($pseudo) > PSEUDO_LENGTH)
            {
                $validation = false;
                Functions::setFlash('Votre pseudo ne doit pas dépasser ' . PSEUDO_LENGTH . ' caractères.');
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
    
            elseif($password !== $password2)
            {
                $validation = false;
                Functions::setFlash('Vos mots de passe ne correspondent pas');
            }
    
            elseif($validation)
            {
                $passHash = password_hash($password, PASSWORD_BCRYPT);

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

    /**
     * modify the user
     */
    function getProfile($newPseudo, $newMail, $newPswd, $newPswd2)
    {
        if(isset($_SESSION['id']))
        {
            $userManager = new UserManager();
    
            $user = $userManager->selectUserId($_SESSION['id']);
            $validation = true;

            /**
             * if the user changes his username
             */
            if(isset($newPseudo) && !empty($newPseudo) && $newPseudo !== $user->getUsername())
            {
                $countUsername = $userManager->countUsername($newPseudo);
    
                if(strlen($newPseudo) > PSEUDO_LENGTH)
                {
                    $validation = false;
                    Functions::setFlash('Votre pseudo ne doit pas dépasser ' . PSEUDO_LENGTH . ' caractères.');
                }
                
                elseif($countUsername)
                {
                    $validation = false;
                    Functions::setFlash('Le pseudo existe déjà !');
                }
    
                elseif($validation)
                {
                    $newPseudo = Functions::check($newPseudo);
                    $user->setUsername($newPseudo);
                    $userManager->updateUsername($user);

                    $_SESSION['username'] = $user->getUsername();
                    Functions::setFlash("Votre compte a bien été mis à jour", "success");
                    header('Location: index.php?action=edit_profile');
                    exit();
                }
            }
    
            /**
             * if the user changes his mail
             */
            if(isset($newMail) && !empty($newMail) && $newMail !== $user->getMail())
            {
                $newMail = Functions::check($newMail);
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
    
            /**
             * if the user changes his password
             */
            if(isset($newPswd) && !empty($newPswd) && $newPswd !== $user->getPassword() && isset($newPswd2) && !empty($newPswd2) && $newPswd2 !== $user->getPassword())
            {
                $pswd = password_hash($newPswd, PASSWORD_BCRYPT);
                $pswd2 = $newPswd2;
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

    /**
     * change the dark session to true and light session to false
     */
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

    /**
     * change the light session to true and dark session to false
     */
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

    /**
     * adding login cookies
     */
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

    /**
     * connect login cookies
     */
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