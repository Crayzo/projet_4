<?php
namespace Models;

class Chapters
{
    private $_id,
            $_title,
            $_content,
            $_addedDate,
            $_modificationDate;

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

        if(isset($data['title']))
        {
            $this->setTitle($data['title']);
        }

        if(isset($data['content']))
        {
            $this->setContent($data['content']);
        }

        if(isset($data['added_date_fr']))
        {
            $this->setAddedDate($data['added_date_fr']);
        }
        
        if(isset($data['modification_date_fr']))
        {
            $this->setModificationDate($data['modification_date_fr']);
        }
    }

    //GETTERS
    public function getId()
    {
        return $this->_id;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function getContent()
    {
        return $this->_content;
    }

    public function getAddedDate()
    {
        return $this->_addedDate;
    }

    public function getModificationDate()
    {
        return $this->_modificationDate;
    }

    //SETTERS
    public function setId($id)
    {
        $this->_id = $id;
    }

    public function setTitle($title)
    {
        $this->_title = $title;
    }

    public function setContent($content)
    {
        $this->_content = $content;
    }

    public function setAddedDate($addedDate)
    {
        $this->_addedDate = $addedDate;
    }

    public function setModificationDate($modificationDate)
    {
        $this->_modificationDate = $modificationDate;
    }
}