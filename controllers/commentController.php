<?php

function deleteComment()
{
    if(isset($_GET['id']) && $_GET['id'] > 0)
    {
        $commentManager = new Project\Models\CommentManager();
        $getId = intval($_GET['id']);
        $comments = $commentManager->selectComment($getId);
        $comment = $comments->fetch();

        if(isset($_SESSION['id']))
        {
            if($_SESSION['id'] === $comment['author_id'])
            {
                $commentManager->deleteComment($getId);
                $report = $commentManager->checkReport($getId);
                $reportExist = $report->rowCount();

                if($reportExist)
                {
                    $commentManager->deleteReport($getId);
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

function getReports()
{
    if(isset($_SESSION['id'], $_SESSION['admin']) && !empty($_SESSION['id']) && !empty($_SESSION['admin']) && $_SESSION['admin'] == true)
    {
        $reportManager = new Project\Models\ReportManager();
        $commentManager = new Project\Models\CommentManager();
        $userManager = new Project\Models\UserManager();
        $reqReports = $reportManager->selectReports();

        if(isset($_GET['approve']) && $_GET['approve'] > 0)
        {
            $getApprove = intval($_GET['approve']);
            $reportManager->deleteReport($getApprove);

            if(isset($_GET['delete']) && $_GET['delete'] > 0)
            {
                $getDelete = intval($_GET['delete']);
                $commentManager->deleteComment($getDelete);
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