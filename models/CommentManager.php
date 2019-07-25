<?php
namespace Models;

class CommentManager extends Manager
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

    public function selectId($comment)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT *, DATE_FORMAT(comment_date, \'%d/%m/%Y à %H:%i:%s\') AS comment_date_fr FROM comments WHERE id = ?');
        $req->execute([
            $comment
        ]);
        $data = $req->fetch();
        return new Comments($data);
    }

    public function selectComment($report)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT *, DATE_FORMAT(comment_date, \'%d/%m/%Y à %H:%i:%s\') AS comment_date_fr FROM comments WHERE id = ?');
        $req->execute([
            $report->getCommentId()
        ]);
        $data = $req->fetch();
        return new Comments($data);
    }

    public function delete(Comments $comment)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM comments WHERE id = ?');
        $req->execute([
            $comment->getId()
        ]);
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
}