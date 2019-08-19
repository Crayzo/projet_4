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
                $id = isset($_GET['id']) ? intval($_GET['id']) : 0; // chapter id
                $submitComment = isset($_POST['submit_comment']) ? true : false; // if the comment is submitted return true
                $comment = isset($_POST['comment']) ? $_POST['comment'] : null; // if the comment exists return the comment
                $idComment = isset($_GET['report']) ? intval($_GET['report']) : 0; // comment id to report
                $submitReport = isset($_POST['submit_report']) ? true : false; // if the report is submitted return true
                $messageReport = isset($_POST['message_report']) ? $_POST['message_report'] : null; // if the message report exists return the message
                $chapterController->getChapter($id, $submitComment, $comment, $submitReport, $idComment, $messageReport);
                break;

            case 'chapters': 
                $chapterController->getChapters();
                break;

            case 'login': 
                $post = !empty($_POST) ? true : false; // if post return true
                $idConnect = isset($_POST['idConnect']) ? $_POST['idConnect'] : null; // if the identifier exists return the identifier
                $passwordConnect = isset($_POST['passwordConnect']) ? $_POST['passwordConnect'] : null; // if the password exists return the password
                $rememberMe = isset($_POST['rememberMe']) ? true : false; // if remember me is checked return true
                $userController->login($post, $idConnect, $passwordConnect, $rememberMe);
                break;

            case 'logout': 
                $userController->logout();
                break;

            case 'register': 
                $post = !empty($_POST) ? true : false; // if post return true
                $pseudo = isset($_POST['pseudo']) ? $_POST['pseudo'] : null; // if the pseudo exists return the pseudo
                $mail = isset($_POST['mail']) ? $_POST['mail'] : null; // if the mail exists return the mail
                $mail2 = isset($_POST['mail2']) ? $_POST['mail2'] : null; // if the mail2 exists return the mail2
                $password = isset($_POST['password']) ? $_POST['password'] : null; // if the password exists return the password
                $password2 = isset($_POST['password2']) ? $_POST['password2'] : null; // if the password2 exists return the password2
                $userController->register($post, $pseudo, $mail, $mail2, $password, $password2);
                break;

            case 'delete_comment': 
                $id = isset($_GET['id']) ? intval($_GET['id']) : 0; // comment id
                $commentController->deleteComment($id);
                break;

            case 'reports': 
                $idReport = isset($_GET['approve']) ? intval($_GET['approve']) : 0; // id of the report
                $idComment = isset($_GET['delete']) ? intval($_GET['delete']) : 0; // id of the comment reported
                $commentController->getReports($idReport, $idComment);
                break;

            case 'accept_cookie': 
                $userController->acceptCookie();
                break;

            case 'new_chapter': 
                $post = !empty($_POST) ? true : false; // if post return true
                $newTitle = isset($_POST['title']) ? $_POST['title'] : null; // if the title exists return the title
                $content = isset($_POST['content']) ? $_POST['content'] : null; // if the content exists return the content
                $chapterController->addChapter($post, $newTitle, $content);
                break;

            case 'edit_chapter': 
                $id = isset($_GET['id']) ? intval($_GET['id']) : 0; // chapter id
                $post = !empty($_POST) ? true : false; // if post return true
                $title = isset($_POST['title']) ? $_POST['title'] : null; // if the title exists return the title
                $content = isset($_POST['content']) ? $_POST['content'] : null; // if the content exists return the content
                $chapterController->editChapter($id, $post, $title, $content);
                break;

            case 'delete_chapter': 
                $id = isset($_GET['id']) ? intval($_GET['id']) : 0; // chapter id
                $chapterController->deleteChapter($id);
                break;

            case 'edit_profile': 
                $newPseudo = isset($_POST['newPseudo']) ? $_POST['newPseudo'] : null; // if newPseudo exist return newPseudo
                $newMail = isset($_POST['newMail']) ? $_POST['newMail'] : null; // if newMail exist return newMail
                $newPswd = isset($_POST['newPswd']) ? $_POST['newPswd'] : null; // if newPswd exist return newPswd
                $newPswd2 = isset($_POST['newPswd2']) ? $_POST['newPswd2'] : null; // if newPswd2 exist return newPswd2
                $userController->getProfile($newPseudo, $newMail, $newPswd, $newPswd2);
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