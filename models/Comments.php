<?php
namespace Models;

class Comments
{
    private $_id,
            $_comment,
            $_chapterId,
            $_authorId,
            $_commentDate;
    
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

        if(isset($data['comment']))
        {
            $this->setComment($data['comment']);
        }

        if(isset($data['chapter_id']))
        {
            $this->setChapterId($data['chapter_id']);
        }

        if(isset($data['author_id']))
        {
            $this->setAuthorId($data['author_id']);
        }
        
        if(isset($data['comment_date_fr']))
        {
            $this->setCommentDate($data['comment_date_fr']);
        }
    }

    //GETTERS
    public function getId()
    {
        return $this->_id;
    }

    public function getComment()
    {
        return $this->_comment;
    }

    public function getChapterId()
    {
        return $this->_chapterId;
    }

    public function getAuthorId()
    {
        return $this->_authorId;
    }

    public function getCommentDate()
    {
        return $this->_commentDate;
    }

    //SETTERS
    public function setId($id)
    {
        $this->_id = $id;
    }

    public function setComment($comment)
    {
        $this->_comment = $comment;
    }

    public function setChapterId($chapterId)
    {
        $this->_chapterId = $chapterId;
    }

    public function setAuthorId($authorId)
    {
        $this->_authorId = $authorId;
    }

    public function setCommentDate($commentDate)
    {
        $this->_commentDate = $commentDate;
    }
}