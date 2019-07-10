<?php
namespace Project\Models;

Class CommentManager extends Manager
{
    public function selectAll($getId)
    {

        $comments = [];

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT *, DATE_FORMAT(comment_date, \'%d/%m/%Y à %H:%i:%s\') AS comment_date_fr FROM comments WHERE chapter_id = ? ORDER BY id DESC');
        $req->execute([$getId]);

        while($data = $req->fetch())
        {
            $comments[] = new Comments($data);
        }

        return $comments;
    }

    public function selectComment($getId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT *, DATE_FORMAT(comment_date, \'%d/%m/%Y à %H:%i:%s\') AS comment_date_fr FROM comments WHERE id = ?');
        $req->execute(array($getId));
        return $req;
    }

    public function deleteComment($getId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM comments WHERE id = ?');
        $req->execute(array($getId));
        return $req;
    }

    public function checkReport($getId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM reports WHERE comment_id = ?');
        $req->execute(array($getId));
        return $req;
    }

    public function insert(Comments $comment)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO comments (comment, chapter_id, author_id, comment_date) VALUES (?,?,?,NOW())');
        $req->execute([
            $comment->getComment(),
            $comment->getChapterId(),
            $comment->getAuthorId()
        ]);
    }

    public function selectAuthor($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT username FROM users WHERE id = ?');
        $req->execute([$id]);
        return $req;
    } 

    public function selectReports($memberId, $commentId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM reports WHERE member_id = ? AND comment_id = ?');
        $req->execute(array($memberId, $commentId));
        return $req;
    }

    public function insertReport($memberId, $commentId, $postMessage)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO reports SET member_id = ?, comment_id = ?, message = ?');
        $req->execute(array($memberId, $commentId, $postMessage));
        return $req;
    }
    
    public function deleteReport($getId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM reports WHERE comment_id = ?');
        $req->execute(array($getId));
        return $req;
    }
}