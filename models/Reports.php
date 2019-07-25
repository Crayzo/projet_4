<?php
namespace Models;

class Reports
{
    private $_id,
            $_memberId,
            $_commentId,
            $_message;

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
        return $this->_id;
    }

    public function getMemberId()
    {
        return $this->_memberId;
    }

    public function getCommentId()
    {
        return $this->_commentId;
    }

    public function getMessage()
    {
        return $this->_message;
    }

    //SETTERS
    public function setId($id)
    {
        $this->_id = $id;
    }

    public function setMemberId($memberId)
    {
        $this->_memberId = $memberId;
    }

    public function setCommentId($commentId)
    {
        $this->_commentId = $commentId;
    }

    public function setMessage($message)
    {
        $this->_message = $message;
    }
}