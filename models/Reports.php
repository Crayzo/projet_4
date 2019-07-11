<?php
namespace Project\Models;

Class Reports
{
    private $id,
            $memberId,
            $commentId,
            $message;

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

        if(isset($data['member_id']))
        {
            $this->setMemberId($data['member_id']);
        }

        if(isset($data['comment_id']))
        {
            $this->setCommentId($data['comment_id']);
        }

        if(isset($data['message']))
        {
            $this->setMessage($data['message']);
        }
    }
    
    //GETTERS
    public function getId()
    {
        return $this->id;
    }

    public function getMemberId()
    {
        return $this->memberId;
    }

    public function getCommentId()
    {
        return $this->commentId;
    }

    public function getMessage()
    {
        return $this->message;
    }

    //SETTERS
    public function setId($id)
    {
        $this->id = $id;
    }

    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;
    }

    public function setCommentId($commentId)
    {
        $this->commentId = $commentId;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }
}