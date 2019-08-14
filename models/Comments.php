<?php

namespace Models;

class Comments
{   
    /**
     * @access private
     */
    private $_id,
            $_comment,
            $_chapterId,
            $_authorId,
            $_commentDate;
    
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
    public function getComment()
    {
        return $this->_comment;
    }

    /**
     * @return var
     */
    public function getChapterId()
    {
        return $this->_chapterId;
    }

    /**
     * @return var
     */
    public function getAuthorId()
    {
        return $this->_authorId;
    }

    /**
     * @return var
     */
    public function getCommentDate()
    {
        return $this->_commentDate;
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
    public function setComment($comment)
    {
        $this->_comment = $comment;
    }

    /**
     * @param string
     */
    public function setChapterId($chapterId)
    {
        $this->_chapterId = $chapterId;
    }

    /**
     * @param string
     */
    public function setAuthorId($authorId)
    {
        $this->_authorId = $authorId;
    }

    /**
     * @param string
     */
    public function setCommentDate($commentDate)
    {
        $this->_commentDate = $commentDate;
    }
}