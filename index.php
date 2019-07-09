<?php
session_start();

require('models/Manager.php');
require('models/Chapters.php');
require('models/ChapterManager.php');
require('models/CommentManager.php');
require('models/ReportManager.php');
require('models/UserManager.php');
require('controllers/chapterController.php');
require('controllers/commentController.php');
require('controllers/userController.php');

cookieConnect();

try 
{
    if(isset($_GET['action'])) 
    {
        if($_GET['action'] == 'chapter')
        {
            getChapter();
        } 
        elseif($_GET['action'] == 'chapters')
        {
            getChapters();
        }
        elseif($_GET['action'] == 'login')
        {
            login();   
        }
        elseif($_GET['action'] == 'logout')
        {
            logout();
        }
        elseif($_GET['action'] == 'register')
        {
            register();
        }
        elseif($_GET['action'] == 'delete_comment')
        {
            deleteComment();
        }
        elseif($_GET['action'] == 'reports')
        {
            getReports();
        }
        elseif($_GET['action'] == 'accept_cookie')
        {
            acceptCookie();
        }
        elseif($_GET['action'] == 'new_chapter')
        {
            addChapter();
        }
        elseif($_GET['action'] == 'edit_chapter')
        {
            editChapter();
        }
        elseif($_GET['action'] == 'delete_chapter')
        {
            deleteChapter();
        }
        elseif($_GET['action'] == 'edit_profile')
        {
            getProfile();
        }
        elseif($_GET['action'] == 'dark_mode')
        {
            darkMode();
        }
        elseif($_GET['action'] == 'light_mode')
        {
            lightMode();
        }
        else
            getLastChapters();
    }
    else
        getLastChapters();
}
catch(Exception $e) 
{
    echo 'Erreur : ' . $e->getMessage();
}