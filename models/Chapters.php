<?php
namespace Project\Models;

Class Chapters
{
    private $id,
            $title,
            $content,
            $addedDate,
            $modificationDate;
    //CONSTRUCT
    public function __construct(Array $data)
    {
        $this->hydrate($data);
    }
    //HYDRATE
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
        if(isset($data['added_date']))
        {
            $this->setAddedDate($data['added_date']);
        }
        if(isset($data['modification_date']))
        {
            $this->setModificationDate($data['modification_date']);
        }
    }
    //GETTERS
    public function getId()
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title;
    }
    public function getContent()
    {
        return $this->content;
    }
    public function getAddedDate()
    {
        return $this->addedDate;
    }
    public function getModificationDate()
    {
        return $this->modificationDate;
    }
    //SETTERS
    public function setId($id)
    {
        $this->id = $id;
    }
    public function setTitle($title)
    {
        $this->title = $title;
    }
    public function setContent($content)
    {
        $this->content = $content;
    }
    public function setAddedDate($addedDate)
    {
        $this->addedDate = $addedDate;
    }
    public function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;
    }
}