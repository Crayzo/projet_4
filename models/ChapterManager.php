<?php
namespace Project\Models;
require_once('models/Manager.php');

Class ChapterManager extends Manager
{
    public function selectLastChapters()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(added_date, \'%d/%m/%Y\') AS added_date_fr, DATE_FORMAT(modification_date, \'%d/%m/%Y\') AS modification_date_fr FROM chapters ORDER BY id DESC LIMIT 0, 4');
        $req->execute();
        return $req;
    }
    public function selectChapter($getId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content FROM chapters WHERE id = ?');
        $req->execute(array($getId));
        return $req;
    }
    public function selectChapters()
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(added_date, \'%d/%m/%Y\') AS added_date_fr, DATE_FORMAT(modification_date, \'%d/%m/%Y\') AS modification_date_fr FROM chapters ORDER BY id DESC');
        $req->execute();
        return $req;
    }
    public function insertChapter($title, $content)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO chapters (title, content, added_date, modification_date) VALUES (?, ?, NOW(), NOW())');
        $req->execute(array($title, $content));
        return $req;
    }
    public function updateChapter($content, $title, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE chapters SET content = ?, title = ?, modification_date = NOW() WHERE id = ?');
        $req->execute(array($content, $title, $id));
        return $req;
    }
    public function deleteChapter($getId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM chapters WHERE id = ?');
        $req->execute(array($getId));
        return $req;
    }
    public function deleteCommentsFromChapter($getId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM comments WHERE chapter_id = ?');
        $req->execute(array($getId));
        return $req;
    }
}