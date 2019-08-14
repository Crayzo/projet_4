<?php

session_start();

require('config.php');
require('models/Functions.php');

Models\Functions::autoload();

$chapterController = new Controllers\ChapterController();
$commentController = new Controllers\CommentController();
$userController = new Controllers\UserController();

$userController->cookieConnect();

try 
{
    if(isset($_GET['action'])) 
    {
        switch($_GET['action'])
        {
            case 'chapter':
                $chapterController->getChapter($_GET['id']);
                break;

            case 'chapters': 
                $chapterController->getChapters();
                break;

            case 'login': 
                $userController->login();
                break;

            case 'logout': 
                $userController->logout();
                break;

            case 'register': 
                $userController->register();
                break;

            case 'delete_comment': 
                $commentController->deleteComment();
                break;

            case 'reports': 
                $commentController->getReports();
                break;

            case 'accept_cookie': 
                $userController->acceptCookie();
                break;

            case 'new_chapter': 
                $chapterController->addChapter();
                break;

            case 'edit_chapter': 
                $chapterController->editChapter();
                break;

            case 'delete_chapter': 
                $chapterController->deleteChapter();
                break;

            case 'edit_profile': 
                $userController->getProfile();
                break;

            case 'dark_mode': 
                $userController->darkMode();
                break;

            case 'light_mode': 
                $userController->lightMode();
                break;

            default:
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