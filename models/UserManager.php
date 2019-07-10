<?php
namespace Project\Models;

Class UserManager extends Manager
{
    public function selectUser($idConnect)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM users WHERE username = :username OR mail = :mail');
        $req->execute(array(
            'username' => $idConnect,
            'mail' => $idConnect));
        $data = $req->fetch();
        return $data;
    }

    public function selectUserPseudo($pseudo)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM users WHERE username = ?');
        $req->execute(array($pseudo));
        return $req;
    }

    public function selectUserMail($mail)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM users WHERE mail = ?');
        $req->execute(array($mail));
        return $req;
    }

    public function selectUserId($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM users WHERE id = ?');
        $req->execute(array($id));
        return $req;
    }

    public function selectUsername($authorId)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT username FROM users WHERE id = ?');
        $req->execute([
            $authorId
        ]);
        $username = $req->fetch();
        return new Users($username);
    } 

    public function selectUserPassword($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT password FROM users WHERE id = ?');
        $req->execute(array($id));
        return $req;
    }

    public function insertNewUser($pseudo, $mail, $password)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO users (username, mail, password) VALUES (?,?,?)');
        $req->execute(array($pseudo, $mail, $password));
        return $req;
    }

    public function updateUsername($pseudo, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET username = ? WHERE id = ?');
        $req->execute(array($pseudo, $id));
        return $req;
    }

    public function updateMail($mail, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET mail = ? WHERE id = ?');
        $req->execute(array($mail, $id));
        return $req;
    }
    
    public function updatePassword($password, $id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
        $req->execute(array($password, $id));
        return $req;
    }

    public function darkMode($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET dark = 1 WHERE id = ?');
        $req->execute(array($id));
        return $req;
    }

    public function lightMode($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET dark = 0 WHERE id = ?');
        $req->execute(array($id));
        return $req;
    }
}