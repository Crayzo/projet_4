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
    function deleteComment($id)
    {
        if($id > 0)
        {
            $commentManager = new CommentManager();
            $reportManager = new ReportManager();
    
            $comment = $commentManager->selectId($id);
    
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
    function getReports($idReport, $idComment)
    {
        if(isset($_SESSION['id'], $_SESSION['admin']) && !empty($_SESSION['id']) && !empty($_SESSION['admin']) && $_SESSION['admin'] == true)
        {
            $reportManager = new ReportManager();
            $commentManager = new CommentManager();
            $userManager = new UserManager();
    
            $reports = $reportManager->select();
            $reportExist = $reportManager->countReports();
    
            if($idReport > 0)
            {
                $reportManager->delete($idReport);
    
                if($idComment > 0)
                {
                    $comment = $commentManager->selectId($idComment);
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