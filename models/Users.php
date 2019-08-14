<?php
namespace Models;

class Users
{
    /**
     * @access private
     */
    private $_id,
            $_username,
            $_password,
            $_mail,
            $_admin,
            $_dark;
    
    /**
     * @param array
     */
    public function __construct(Array $data)
    {
        $this->hydrate($data);
    }

    /**
     * @param array
     */
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

    /**
     * @return var
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return var
     */
    public function getUsername()
    {
        return $this->_username;
    }

    /**
     * @return var
     */
    public function getPassword()
    {
        return $this->_password;
    }

    /**
     * @return var
     */
    public function getMail()
    {
        return $this->_mail;
    }

    /**
     * @return var
     */
    public function getAdmin()
    {
        return $this->_admin;
    }

    /**
     * @return var
     */
    public function getDark()
    {
        return $this->_dark;
    }

    //SETTERS

    /**
     * @param string
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @param string
     */
    public function setUsername($username)
    {
        $this->_username = $username;
    }

    /**
     * @param string
     */
    public function setPassword($password)
    {
        $this->_password = $password;
    }

    /**
     * @param string
     */
    public function setMail($mail)
    {
        $this->_mail = $mail;
    } 

    /**
     * @param string
     */
    public function setAdmin($admin)
    {
        $this->_admin = $admin;
    }

    /**
     * @param string
     */
    public function setDark($dark)
    {
        $this->_dark = $dark;
    } 
}