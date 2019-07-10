<?php
namespace Project\Models;

Class Users
{
    private $id,
            $username,
            $password,
            $mail,
            $admin,
            $dark;
    
    public function __construct(Array $data)
    {
        $this->hydrate($data);
    }

    public function hydrate(Array $data)
    {
        if(isset($data['id']))
        {
            $this->setId($data['id']);
        }

        if(isset($data['username']))
        {
            $this->setUsername($data['username']);
        }

        if(isset($data['password']))
        {
            $this->setPassword($data['password']);
        }

        if(isset($data['mail']))
        {
            $this->setMail($data['mail']);
        }

        if(isset($data['admin']))
        {
            $this->setAdmin($data['admin']);
        }

        if(isset($data['dark']))
        {
            $this->setDark($data['dark']);
        }
    }

    //GETTERS
    public function getId()
    {
        return $this->id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getMail()
    {
        return $this->mail;
    }

    public function getAdmin()
    {
        return $this->admin;
    }

    public function getDark()
    {
        return $this->dark;
    }

    //SETTERS
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setUsername($username)
    {
        $this->username = $username;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
    } 

    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    public function setDark($dark)
    {
        $this->dark = $dark;
    } 
}