<?php
namespace Project\Models;

class UserManager extends Manager
{
    public function selectUser($idConnect)
    {
        $user = [];

        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM users WHERE username = :username OR mail = :mail');
        $req->execute([
            'username' => $idConnect,
            'mail' => $idConnect
        ]);
        $data = $req->fetch();

        if($data === false)
        {
            return false;
        }
        else
        {
            return new Users($data);
        }
    }

    public function countUserPseudo($pseudo)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM users WHERE username = ?');
        $req->execute([$pseudo]);
        $count = $req->rowCount();
        return $count;
    }

    public function countUserMail($mail)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM users WHERE mail = ?');
        $req->execute([$mail]);
        $count = $req->rowCount();
        return $count;
    }

    public function selectUserId($data)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM users WHERE id = ?');
        $req->execute([
            $data
        ]);
        $data = $req->fetch();
        return new Users($data);
    }

    public function selectUsername($id)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT username FROM users WHERE id = ?');
        $req->execute([
            $id
        ]);
        $username = $req->fetch();
        return new Users($username);
    } 

    public function countUsername($username)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT username FROM users WHERE username = ?');
        $req->execute([
            $username
        ]);
        $count = $req->fetch();
        return $count;
    }

    public function selectUserPassword(Users $user)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT password FROM users WHERE id = ?');
        $req->execute([
            $user->getId()
        ]);
        $data = $req->fetch();
        return new Users($data);
    }

    public function insertNewUser(Users $user)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('INSERT INTO users (username, mail, password) VALUES (?,?,?)');
        $req->execute([
            $user->getUsername(),
            $user->getMail(),
            $user->getPassword()
        ]);
    }

    public function updateUsername(Users $user)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET username = ? WHERE id = ?');
        $req->execute([
            $user->getUsername(),
            $user->getId()
        ]);
    }

    public function updateMail(Users $user)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET mail = ? WHERE id = ?');
        $req->execute([
            $user->getMail(),
            $user->getId()
        ]);
    }
    
    public function updatePassword(Users $user)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET password = ? WHERE id = ?');
        $req->execute([
            $user->getPassword(),
            $user->getId()
        ]);
    }

    public function darkMode(Users $user)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET dark = 1 WHERE id = ?');
        $req->execute([
            $user->getId()
        ]);
    }

    public function lightMode(Users $user)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('UPDATE users SET dark = 0 WHERE id = ?');
        $req->execute([
            $user->getId()
        ]);
    }
}