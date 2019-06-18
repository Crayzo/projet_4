<?php
namespace Project\Models;
require_once('models/Manager.php');

Class UserManager extends Manager
{
    public function selectUser($idConnect)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM members WHERE username = :username OR mail = :mail');
        $req->execute(array(
            'username' => $idConnect,
            'mail' => $idConnect));
        $data = $req->fetch();
        return $data;
    }
    public function selectUserPseudo($pseudo)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM members WHERE username = ?');
        $req->execute(array($pseudo));
        return $req;
    }
    public function selectUserMail($mail)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM members WHERE mail = ?');
        $req->execute(array($mail));
        return $req;
    }
    public function selectUserId($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM members WHERE id = ?');
        $req->execute(array($id));
        return $req;
    }
    public function selectUserPassword($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT password FROM members WHERE id = ?');
        $req->execute(array($id));
        return $req;
    }
    public function insertNewUser($pseudo, $mail, $password)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO members (username, mail, password) VALUES (?,?,?)');
        $req->execute(array($pseudo, $mail, $password));
        return $req;
    }
    public function updateUsername($pseudo, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE members SET username = ? WHERE id = ?');
        $req->execute(array($pseudo, $id));
        return $req;
    }
    public function updateMail($mail, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE members SET mail = ? WHERE id = ?');
        $req->execute(array($mail, $id));
        return $req;
    }
    public function updatePassword($password, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE members SET password = ? WHERE id = ?');
        $req->execute(array($password, $id));
        return $req;
    }
    public function darkMode($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE members SET dark = 1 WHERE id = ?');
        $req->execute(array($id));
        return $req;
    }
    public function lightMode($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE members SET dark = 0 WHERE id = ?');
        $req->execute(array($id));
        return $req;
    }
}