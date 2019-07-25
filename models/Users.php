<?php
namespace Models;

class Users
{
    private $_id,
            $_username,
            $_password,
            $_mail,
            $_admin,
            $_dark;
    
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
        return $this->_id;
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function getPassword()
    {
        return $this->_password;
    }

    public function getMail()
    {
        return $this->_mail;
    }

    public function getAdmin()
    {
        return $this->_admin;
    }

    public function getDark()
    {
        return $this->_dark;
    }

    //SETTERS
    public function setId($id)
    {
        $this->_id = $id;
    }

    public function setUsername($username)
    {
        $this->_username = $username;
    }

    public function setPassword($password)
    {
        $this->_password = $password;
    }

    public function setMail($mail)
    {
        $this->_mail = $mail;
    } 

    public function setAdmin($admin)
    {
        $this->_admin = $admin;
    }

    public function setDark($dark)
    {
        $this->_dark = $dark;
    } 
}