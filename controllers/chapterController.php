<?php
require_once('models/ChapterManager.php');
require_once('models/CommentManager.php');

function getLastChapters()
{
    $chapterManager = new Project\Models\ChapterManager();
    $chapters = $chapterManager->selectLastChapters();
    require('views/homeView.php');
}
function getChapter()
{
    if(isset($_GET['id']) && $_GET['id'] > 0) 
    {
        $getId = intval($_GET['id']);
        $chapterManager = new Project\Models\ChapterManager();
        $data = $chapterManager->selectChapter($getId);
        $chapter = $data->fetch();
    
        $commentManager = new Project\Models\CommentManager();
        /* SUBMIT A COMMENT */
        if(isset($_POST['submit_comment']))
        {
            if(isset($_SESSION['username'], $_POST['comment']) && !empty($_SESSION['username']) && !empty($_POST['comment']))
            {
                $postComment = htmlspecialchars($_POST['comment']);
                $commentManager->insertComment($postComment, $getId, $_SESSION['id']);
                $success = "Votre commentaire a été ajouté avec succès";
            }
            else
                $error = "Vous devez écrire un commentaire avant d'envoyer !";
        }
        $comments = $commentManager->selectComments($getId);
        /* SUBMIT A REPORT */
        if(isset($_POST['submit_report']))
        {
            if(!empty($_POST))
            {
                if(isset($_SESSION['id'], $_GET['report']) && !empty($_POST['message_report']) && $_GET['report'] > 0)
                {
    
                    $getReport = intval($_GET['report']);
                    $selectReports = $commentManager->selectReports($_SESSION['id'], $getReport);
                    $reportExist = $selectReports->rowCount();
                    if(!$reportExist)
                    {
                        $postMessage = htmlspecialchars($_POST['message_report']);
                        $commentManager->insertReport($_SESSION['id'], $getReport, $postMessage);
                    }
                    else
                        echo "Vous avez déjà signalé ce commentaire";
                }
            }
            header("Location: index.php?action=chapter&id=$getId");
        }
        require('views/chapterView.php');
    }
    else
        header('Location: index.php');

}
function getChapters()
{
    $chapterManager = new Project\Models\ChapterManager();
    $chapters = $chapterManager->selectChapters();
    require('views/chaptersView.php');
}
function addChapter()
{
    if(isset($_SESSION['id'], $_SESSION['admin']) && !empty($_SESSION['id']) && !empty($_SESSION['admin']) && $_SESSION['admin'] == true)
    {
        if(!empty($_POST))
        {
            if(isset($_POST['content']) && !empty($_POST['content']) && isset($_POST['title']) && !empty($_POST['title']))
            {
                $chapterManager = new Project\Models\ChapterManager();
                $chapterManager->insertChapter($_POST['title'], $_POST['content']);
                $success = "Le chapitre a bien été ajouté";
            }
            else
                $error = "Tous les champs doivent être complétés !";
        }
        require('views/newChapterView.php');
    }
    else
        header('Location: index.php');
    
}
function editChapter()
{
    if(isset($_SESSION['id'], $_SESSION['admin']) && !empty($_SESSION['id']) && !empty($_SESSION['admin']) && $_SESSION['admin'] == true)
    {
        if(isset($_GET['id']) && $_GET['id'] > 0)
        {
            $chapterManager = new Project\Models\ChapterManager();
            $getId = intval($_GET['id']);
            $reqChapter = $chapterManager->selectChapter($getId);
            $data = $reqChapter->fetch();
            if(!empty($_POST))
            {
                if(isset($_POST['content']) && !empty($_POST['content']) && isset($_POST['title']) && !empty($_POST['title']))
                {
                    $chapterManager->updateChapter($_POST['content'], $_POST['title'], $getId);
                    $data["content"] = $_POST['content'];
                    $data["title"] = $_POST['title'];
                    $success = "Le chapitre a bien été modifié !";
                }
                else
                    $error = "Tous les champs doivent être complétés !";
            }
            require('views/editChapterView.php');
        }
    }
    else
        header("Location: index.php");
}
function deleteChapter()
{
    if(isset($_SESSION['id'], $_SESSION['admin']) && !empty($_SESSION['id']) && !empty($_SESSION['admin']) && $_SESSION['admin'] == true)
    {
        if(isset($_GET['id']) && $_GET['id'] > 0)
        {
            $chapterManager = new Project\Models\ChapterManager();
            $getId = intval($_GET['id']);
            $chapterManager->deleteChapter($getId);
            $chapterManager->deleteCommentsFromChapter($getId);
            header("Location: index.php?action=chapters");
        }
        else
            header('Location: index.php');
    }
}