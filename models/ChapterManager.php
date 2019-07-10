<?php
namespace Project\Models;

Class ChapterManager extends Manager
{
    public function getLastChapters()
    {
        $chapters = [];
        
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(added_date, \'%d/%m/%Y\') AS added_date_fr, DATE_FORMAT(modification_date, \'%d/%m/%Y\') AS modification_date_fr FROM chapters ORDER BY id DESC LIMIT 0, 4');
        $req->execute();

        while($data = $req->fetch())
        {
            $chapters[] = new Chapters($data);
        }
       
        return $chapters;
    }

    public function get($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM chapters WHERE id = ?');
        $req->execute([
            $id
        ]);
        $data = $req->fetch();
        return new Chapters($data);  
    }

    public function getAll()
    {
        $chapters = [];

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT id, title, content, DATE_FORMAT(added_date, \'%d/%m/%Y\') AS added_date_fr, DATE_FORMAT(modification_date, \'%d/%m/%Y\') AS modification_date_fr FROM chapters ORDER BY id DESC');
        $req->execute();

        while($data = $req->fetch())
        {
            $chapters[] = new Chapters($data);
        }

        return $chapters;
    }

    public function add(Chapters $chapter)
    {   
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO chapters (title, content, added_date, modification_date) VALUES (?, ?, NOW(), NOW())');
        $req->execute([
            $chapter->getTitle(),
            $chapter->getContent()
        ]);
    }

    public function update(Chapters $chapter)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE chapters SET content = ?, title = ?, modification_date = NOW() WHERE id = ?');
        $req->execute([
            $chapter->getContent(),
            $chapter->getTitle(),
            $chapter->getId()
        ]);
    }
    
    public function delete($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('DELETE FROM chapters WHERE id = ?');
        $req->execute([$id]);

        $req = $db->prepare('DELETE FROM comments WHERE chapter_id = ?');
        $req->execute([$id]);
    }
}