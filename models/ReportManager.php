<?php
namespace Project\Models;

Class ReportManager extends Manager
{
    public function select()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM reports ORDER BY id DESC LIMIT 0,10');
        $req->execute();
        return $req;
    }

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

    public function delete($getApprove)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM reports WHERE id = ?');
        $req->execute(array($getApprove));
        return $req;
    }

    public function countReports(Reports $report)
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
}