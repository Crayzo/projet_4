<?php
namespace Models;

class ReportManager extends Manager
{
    /**
     * @return array
     */
    public function select()
    {
        $reports = [];

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM reports ORDER BY id DESC LIMIT 0,10');
        $req->execute();

        while($data = $req->fetch())
        {
            $reports[] = new Reports($data);
        }

        return $reports;
    }

    /**
     * @param object
     */
    public function insert(Reports $report)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO reports SET member_id = ?, comment_id = ?, message = ?');
        $req->execute([
            $report->getMemberId(),
            $report->getCommentId(),
            $report->getMessage()
        ]);
    }

    /**
     * @param int
     */
    public function delete($getApprove)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM reports WHERE id = ?');
        $req->execute([$getApprove]);
    }

    /**
     * @param object
     */
    public function deleteCommentId(Comments $comment)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM reports WHERE comment_id = ?');
        $req->execute([
            $comment->getId()
        ]);
    }
    
    /**
     * @param object
     * @return int
     */
    public function countReportsId(Reports $report)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM reports WHERE member_id = ? AND comment_id = ?');
        $req->execute([
            $report->getMemberId(),
            $report->getCommentId()
        ]);
        $count = $req->rowCount();
        return $count;
    }

    /**
     * @return int
     */
    public function countReports()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM reports');
        $req->execute();
        $count = $req->rowCount();
        return $count;
    }

    /**
     * @param int
     * @return int
     */
    public function selectCommentId($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM reports WHERE comment_id = ?');
        $req->execute([
            $id
        ]);
        $count = $req->rowCount();
        return $count;
    }
}