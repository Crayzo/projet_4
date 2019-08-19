<?php

namespace Controllers;

use Models\ChapterManager;
use Models\Chapters;
use Models\CommentManager;
use Models\Comments;
use Models\Functions;
use Models\ReportManager;
use Models\Reports;
use Models\UserManager;

class ChapterController
{   
    /**
     * show the last 4 chapters
     */
    function getLastChapters()
    {
        $chapterManager = new ChapterManager();
        $chapters = $chapterManager->getLastChapters();
        require('views/homeView.php');
    }

    /**
     * show a chapter
     */
    function getChapter($id, $submitComment, $comment, $submitReport, $idComment, $messageReport)
    {
        $validation = true;
    
        if($id > 0) 
        {

            $chapterManager = new ChapterManager();
            $userManager = new UserManager();
            $commentManager = new CommentManager();
            $reportManager = new ReportManager();
    
            $chapter = $chapterManager->get($id);
    
            if(!$chapter)
            {
                Functions::setFlash("Idendifiant de chapitre inconnu");
                header('Location: index.php?action=chapters');
                exit();
            }
            
            /**
             * submit a comment
             */
            if($submitComment)
            {
                $postComment = Functions::check($comment);
                
                if(!isset($_SESSION['username'], $postComment) || empty($_SESSION['username']) || empty($postComment))
                {
                    $validation = false;
                    Functions::setFlash("Vous devez écrire un commentaire avant d'envoyer !");
                }
    
                elseif(strlen($postComment) > MESSAGE_LENGTH)
                {
                    $validation = false;
                    Functions::setFlash('Votre commentaire ne doit pas dépasser ' . MESSAGE_LENGTH . ' caractères.');
                }
    
                elseif($validation)
                {
                    $comment = new Comments([
                        'comment' =>  $postComment,
                        'chapter_id' => $chapter->getId(),
                        'author_id' => $_SESSION['id']
                    ]);
    
                    $commentManager->insert($comment);
                    Functions::setFlash("Votre commentaire a été ajouté avec succès.", "success");
                    header('Location: index.php?action=chapter&id=' . $chapter->getId() . '#form');
                    exit();
                }
            }
            
            $comments = $commentManager->selectAll($id);
    
            /**
             * submit a report
             */
            if($submitReport)
            {
                if(isset($_SESSION['id'], $idComment) && !empty($messageReport) && $idComment > 0)
                {
                    $validation = true;
                    $messageReport = Functions::check($messageReport);
    
                    if(!isset($messageReport) || empty($messageReport))
                    {
                        $validation = false;
                        Functions::setFlash("Vous devez écrire la raison avant de signaler !");
                    }
    
                    elseif(strlen($messageReport) > MESSAGE_LENGTH)
                    {
                        $validation = false;
                        Functions::setFlash('Votre signalement ne doit pas dépasser ' . MESSAGE_LENGTH . ' caractères.');
                    }
                    
                    elseif($validation)
                    {
    
                        $report = new Reports([
                            'member_id' => $_SESSION['id'],
                            'comment_id' => $idComment,
                            'message' => $messageReport
                        ]);
    
                        $reportExist = $reportManager->countReportsId($report);
    
                        if(!$reportExist)
                        {
                            $reportManager->insert($report);
                            Functions::setFlash("Le commentaire a été signalé avec succès.", "success");
                            header("Location: index.php?action=chapter&id=" . $chapter->getId() . "#form"); 
                            exit();               
                        }
                    } 
                }
            }
            require('views/chapterView.php');
        }
        else
        {
            header('Location: index.php');
        }
    
    }

    /**
     * show all chapters
     */
    function getChapters()
    {
        $chapterManager = new ChapterManager();
        $chapters = $chapterManager->getAll();

        require('views/chaptersView.php');
    }
    
    /**
     * add a chapter
     */
    function addChapter($post, $newTitle, $content)
    {
        if(!isset($_SESSION['admin']))
        {  
            header('Location: index.php');
            exit();
        }

        if($post)
        {
            $chapterManager = new ChapterManager();
    
            $validation = true;
    
            if(!isset($content, $newTitle) || empty($content) || empty($newTitle))
            {
                $validation = false;
                Functions::setFlash("Tous les champs doivent être complétés !");
            }
    
            elseif($validation)
            {
                $chapter = new Chapters([
                    "title" => $newTitle,
                    "content" => $content
                ]);
      
                $chapterManager->add($chapter);
                Functions::setFlash("Le chapitre a été ajouté avec succès.", "success");
                header('Location: index.php?action=chapters');
                exit();
            }
        }
        require('views/addChapterView.php');
    }
    
    /**
     * edit a chapter
     */
    function editChapter($id, $post, $title, $content)
    {
        if(!isset($_SESSION['admin']))
        {  
            header('Location: index.php');
            exit();
        }

        if($id > 0)
        {
            $chapterManager = new ChapterManager();
    
            $data = $chapterManager->get($id);
            $validation = true;
    
            if($post)
            {
                if(!isset($content, $title) || empty($content) || empty($title))
                {
                    $validation = false;
                    Functions::setFlash("Tous les champs doivent être complétés !");
                }
                
                elseif($validation)
                {
                    $chapter = new Chapters([
                        'id' => $id,
                        'content' => $content,
                        'title' => $title
                    ]);
                    
                    $chapterManager->update($chapter);
                    Functions::setFlash("Le chapitre a été modifié avec succès. <a class='alert-link' href='index.php?action=chapter&id=$id'>Retour au chapitre</a>", "success");
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
    
    /**
     * delete a chapter
     */
    function deleteChapter($id)
    {
        if(isset($_SESSION['admin']) && !empty($_SESSION['admin']) && $_SESSION['admin'] == true)
        {
            if($id > 0)
            {
                $chapterManager = new ChapterManager();
                
                $chapterManager->delete($id);
                Functions::setFlash("Le chapitre a été supprimé avec succès", "success");
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
}