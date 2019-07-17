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
        $chapterManager = new Project\Models\ChapterManager();
        $userManager = new Project\Models\UserManager();
        $commentManager = new Project\Models\CommentManager();
        $reportManager = new Project\Models\ReportManager();

        $getId = intval($_GET['id']);
        $chapter = $chapterManager->get($getId);

        if(!$chapter)
        {
            Project\Models\Functions::setFlash("Idendifiant de chapitre inconnu");
            header('Location: index.php?action=chapters');
            die();
        }
        /* SUBMIT A COMMENT */
        if(isset($_POST['submit_comment']))
        {
            $postComment = Project\Models\Functions::check($_POST['comment']);
            
            if(!isset($_SESSION['username'], $postComment) || empty($_SESSION['username']) || empty($postComment))
            {
                $validation = false;
                Project\Models\Functions::setFlash("Vous devez écrire un commentaire avant d'envoyer !");
            }

            elseif(strlen($postComment) > 500)
            {
                $validation = false;
                Project\Models\Functions::setFlash("Votre commentaire ne doit pas dépasser 500 caractères.");
            }

            elseif($validation)
            {
                $comment = new Project\Models\Comments([
                    'comment' =>  $postComment,
                    'chapter_id' => $chapter->getId(),
                    'author_id' => $_SESSION['id']
                ]);

                $commentManager->insert($comment);
                Project\Models\Functions::setFlash("Votre commentaire a été ajouté avec succès.", "success");
                header('Location: index.php?action=chapter&id=' . $chapter->getId() . '#form');
                exit();
            }
        }
        
        $comments = $commentManager->selectAll($getId);

        /* SUBMIT A REPORT */
        if(isset($_POST['submit_report']))
        { 
            if(isset($_SESSION['id'], $_GET['report']) && !empty($_POST['message_report']) && $_GET['report'] > 0)
            {
                $validation = true;
                $messageReport = Project\Models\Functions::check($_POST['message_report']);

                if(!isset($messageReport) || empty($messageReport))
                {
                    $validation = false;
                    Project\Models\Functions::setFlash("Vous devez écrire la raison avant de signaler !");
                }

                elseif(strlen($messageReport) > 500)
                {
                    $validation = false;
                    Project\Models\Functions::setFlash("Votre signalement ne doit pas dépasser 500 caractères.");
                }
                
                elseif($validation)
                {

                    $report = new Project\Models\Reports([
                        'member_id' => $_SESSION['id'],
                        'comment_id' => $_GET['report'],
                        'message' => $messageReport
                    ]);

                    $reportExist = $reportManager->countReportsId($report);

                    if(!$reportExist)
                    {
                        $reportManager->insert($report);
                        Project\Models\Functions::setFlash("Le commentaire a été signalé avec succès.", "success");
                        header("Location: index.php?action=chapter&id=" . $chapter->getId() . "#form"); 
                        exit();               
                    }
                } 
            }
        }
        require('views/chapterView.php');
    }
    else
        header('Location: index.php');

}

function getChapters()
{
    $chapterManager = new Project\Models\ChapterManager();

    $chapters = $chapterManager->getAll();
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
        $chapterManager = new Project\Models\ChapterManager();

        $validation = true;

        if(!isset($_POST['content'], $_POST['title']) || empty($_POST['content']) || empty($_POST['title']))
        {
            $validation = false;
            Project\Models\Functions::setFlash("Tous les champs doivent être complétés !");
        }

        elseif($validation)
        {
            $chapter = new Project\Models\Chapters([
                "title" => $_POST['title'],
                "content" => $_POST['content']
            ]);
  
            $chapterManager->add($chapter);
            Project\Models\Functions::setFlash("Le chapitre a été ajouté avec succès.", "success");
            header('Location: index.php?action=chapters');
            exit();
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
                Project\Models\Functions::setFlash("Tous les champs doivent être complétés !");
            }
            
            elseif($validation)
            {
                $chapter = new Project\Models\Chapters([
                    'id' => $getId,
                    'content' => $_POST['content'],
                    'title' => $_POST['title']
                ]);
                
                $chapterManager->update($chapter);
                Project\Models\Functions::setFlash("Le chapitre a été modifié avec succès. <a class='alert-link' href='index.php?action=chapter&id=$getId'>Retour au chapitre</a>", "success");
                header('Location: index.php?action=edit_chapter&id=' . $data->getId());
                exit();
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
    if(isset($_SESSION['admin']) && !empty($_SESSION['admin']) && $_SESSION['admin'] == true)
    {
        if(isset($_GET['id']) && $_GET['id'] > 0)
        {
            $chapterManager = new Project\Models\ChapterManager();
            
            $getId = intval($_GET['id']);
            $chapterManager->delete($getId);
            Project\Models\Functions::setFlash("Le chapitre a été supprimé avec succès", "success");
            header("Location: index.php?action=chapters");
            exit();
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