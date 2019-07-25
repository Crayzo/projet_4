<?php
session_start();

require('models/Functions.php');
Models\Functions::autoload();

use Controllers\ChapterController;
use Controllers\CommentController;
use Controllers\UserController;

$chapterController = new ChapterController();
$commentController = new CommentController();
$userController = new UserController();

$userController->cookieConnect();

try 
{
    if(isset($_GET['action'])) 
    {
        if($_GET['action'] == 'chapter')
        {
            $chapterController->getChapter();
        } 

        elseif($_GET['action'] == 'chapters')
        {
            $chapterController->getChapters();
        }
        
        elseif($_GET['action'] == 'login')
        {
            $userController->login();   
        }

        elseif($_GET['action'] == 'logout')
        {
            $userController->logout();
        }

        elseif($_GET['action'] == 'register')
        {
            $userController->register();
        }
        
        elseif($_GET['action'] == 'delete_comment')
        {
            $commentController->deleteComment();
        }

        elseif($_GET['action'] == 'reports')
        {
            $commentController->getReports();
        }

        elseif($_GET['action'] == 'accept_cookie')
        {
            $userController->acceptCookie();
        }

        elseif($_GET['action'] == 'new_chapter')
        {
            $chapterController->addChapter();
        }

        elseif($_GET['action'] == 'edit_chapter')
        {
            $chapterController->editChapter();
        }

        elseif($_GET['action'] == 'delete_chapter')
        {
            $chapterController->deleteChapter();
        }

        elseif($_GET['action'] == 'edit_profile')
        {
            $userController->getProfile();
        }

        elseif($_GET['action'] == 'dark_mode')
        {
            $userController->darkMode();
        }

        elseif($_GET['action'] == 'light_mode')
        {
            $userController->lightMode();
        }
        
        else
        {
            $chapterController->getLastChapters();
        }
    }
    else
    {
        $chapterController->getLastChapters();
    }
}
catch(Exception $e) 
{
    echo 'Erreur : ' . $e->getMessage();
}