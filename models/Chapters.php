<?php

namespace Models;

class Chapters
{
    /**
     * @access private
     */
    private $_id,
            $_title,
            $_content,
            $_addedDate,
            $_modificationDate;

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
    public function getTitle()
    {
        return $this->_title;
    }

    /**
     * @return var
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * @return var
     */
    public function getAddedDate()
    {
        return $this->_addedDate;
    }

    /**
     * @return var
     */
    public function getModificationDate()
    {
        return $this->_modificationDate;
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
    public function setTitle($title)
    {
        $this->_title = $title;
    }

    /**
     * @param string
     */
    public function setContent($content)
    {
        $this->_content = $content;
    }

    /**
     * @param string
     */
    public function setAddedDate($addedDate)
    {
        $this->_addedDate = $addedDate;
    }

    /**
     * @param string
     */
    public function setModificationDate($modificationDate)
    {
        $this->_modificationDate = $modificationDate;
    }
}