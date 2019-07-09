<?php

function getLastChapters()
{
    $chapterManager = new Project\Models\ChapterManager();
    $chapters = $chapterManager->getLastChapters();
    require('views/homeView.php');
}

function getChapter()
{
    $validation = true;

    if(isset($_GET['id']) && $_GET['id'] > 0) 
    {
        $getId = intval($_GET['id']);
        $chapterManager = new Project\Models\ChapterManager();
        $chapter = $chapterManager->get($getId);

        $commentManager = new Project\Models\CommentManager();
        /* SUBMIT A COMMENT */
        if(isset($_POST['submit_comment']))
        {
            if(!isset($_SESSION['username'], $_POST['comment']) || empty($_SESSION['username']) || empty($_POST['comment']))
            {
                $validation = false;
                $error = "Vous devez écrire un commentaire avant d'envoyer !";
            }

            elseif($validation)
            {
                $postComment = htmlspecialchars($_POST['comment']);
                $commentManager->insertComment($postComment, $getId, $_SESSION['id']);
                $success = "Votre commentaire a été ajouté avec succès";
            }
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
    if(!isset($_SESSION['admin']))
    {  
        header('Location: index.php');
        exit();
    }
    if(!empty($_POST))
    {
        $validation = true;

        if(!isset($_POST['content'], $_POST['title']) || empty($_POST['content']) || empty($_POST['title']))
        {
            $validation = false;
            $error = 'Tous les champs doivent être complétés !';
        }
        elseif($validation)
        {
            $chapter = new Project\Models\Chapters([
                "title" => $_POST['title'],
                "content" => $_POST['content']
            ]);
            $chapterManager = new Project\Models\ChapterManager();
            $chapterManager->add($chapter);
            header('Location: index.php?action=chapters');
        }
    }
    require('views/addChapterView.php');
}

function editChapter()
{
    if(!isset($_SESSION['admin']))
    {  
        header('Location: index.php');
        exit();
    }
    if(isset($_GET['id']) && $_GET['id'] > 0)
    {
        $chapterManager = new Project\Models\ChapterManager();
        $getId = intval($_GET['id']);
        $data = $chapterManager->get($getId);
        $validation = true;

        if(!empty($_POST))
        {
            if(!isset($_POST['content'], $_POST['title']) || empty($_POST['content']) || empty($_POST['title']))
            {
                $validation = false;
                $error = "Tous les champs doivent être complétés !";
            }
            
            elseif($validation)
            {
                $chapter = new Project\Models\Chapters([
                    'id' => $_GET['id'],
                    'content' => $_POST['content'],
                    'title' => $_POST['title']
                ]);
                $chapterManager->update($chapter);
                header('Location: index.php?action=chapter&id=' . $data->getId());
            }
        }
        require('views/editChapterView.php');
    }
    else
        header("Location: index.php");
        exit();
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