<?php
namespace Project\Models;

Class Comments
{
    private $id,
            $comment,
            $chapterId,
            $authorId,
            $commentDate;
    
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
        return $this->id;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function getChapterId()
    {
        return $this->chapterId;
    }

    public function getAuthorId()
    {
        return $this->authorId;
    }

    public function getCommentDate()
    {
        return $this->commentDate;
    }

    //SETTERS
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function setChapterId($chapterId)
    {
        $this->chapterId = $chapterId;
    }

    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;
    }

    public function setCommentDate($commentDate)
    {
        $this->commentDate = $commentDate;
    }
}