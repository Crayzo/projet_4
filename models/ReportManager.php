<?php
namespace Project\Models;

Class ReportManager extends Manager
{
    public function selectReports()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM reports ORDER BY id DESC LIMIT 0,10');
        $req->execute();
        return $req;
    }
    public function deleteReport($getApprove)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM reports WHERE id = ?');
        $req->execute(array($getApprove));
        return $req;
    }
}