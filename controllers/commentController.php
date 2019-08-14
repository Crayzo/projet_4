<?php

namespace Controllers;

use Models\CommentManager;
use Models\ReportManager;
use Models\UserManager;

class CommentController
{
    /**
     * delete a comment
     */
    function deleteComment()
    {
        if(isset($_GET['id']) && $_GET['id'] > 0)
        {
            $commentManager = new CommentManager();
            $reportManager = new ReportManager();
    
            $getId = intval($_GET['id']);
            $comment = $commentManager->selectId($getId);
    
            if(isset($_SESSION['id']))
            {
                if($_SESSION['id'] === $comment->getAuthorId())
                {
                    $commentManager->delete($comment);
                    $reportExist = $reportManager->selectCommentId($comment->getId());
    
                    if($reportExist)
                    {
                        $reportManager->deleteCommentId($comment);
                    }
    
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
                }
            }
            else
            {
                header('Location: index.php');
                exit();
            }
        } 
    }
    
    /**
     * get all reported comments
     */
    function getReports()
    {
        if(isset($_SESSION['id'], $_SESSION['admin']) && !empty($_SESSION['id']) && !empty($_SESSION['admin']) && $_SESSION['admin'] == true)
        {
            $reportManager = new ReportManager();
            $commentManager = new CommentManager();
            $userManager = new UserManager();
    
            $reports = $reportManager->select();
            $reportExist = $reportManager->countReports();
    
            if(isset($_GET['approve']) && $_GET['approve'] > 0)
            {
                $getApprove = intval($_GET['approve']);
                $reportManager->delete($getApprove);
    
                if(isset($_GET['delete']) && $_GET['delete'] > 0)
                {
                    $getDelete = intval($_GET['delete']);
                    $comment = $commentManager->selectId($getDelete);
                    $commentManager->delete($comment);
                }
                header('Location: index.php?action=reports');
            }
            require('views/reportView.php');
        }
        else
        {
            header('Location: index.php');
            exit();
        }  
    }
}