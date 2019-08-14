<?php
namespace Models;

class Reports
{
    /**
     * @access private
     */
    private $_id,
            $_memberId,
            $_commentId,
            $_message;

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
    public function getMemberId()
    {
        return $this->_memberId;
    }

    /**
     * @return var
     */
    public function getCommentId()
    {
        return $this->_commentId;
    }

    /**
     * @return var
     */
    public function getMessage()
    {
        return $this->_message;
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
    public function setMemberId($memberId)
    {
        $this->_memberId = $memberId;
    }

    /**
     * @param string
     */
    public function setCommentId($commentId)
    {
        $this->_commentId = $commentId;
    }

    /**
     * @param string
     */
    public function setMessage($message)
    {
        $this->_message = $message;
    }
}