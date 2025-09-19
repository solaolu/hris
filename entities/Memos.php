<?php 
namespace Entity;

class Memos{
	
    public $id;

    public function getId(){
        return $this->id;
    }

    public $owner;

    public function getOwner(){
        return $this->owner;
    }


    public function setOwner($owner){
        $this->owner = $owner;
        return $this;
    }

    public $recipients;

    public function getRecipients(){
        return $this->recipients;
    }


    public function setRecipients($recipients){
        $this->recipients = $recipients;
        return $this;
    }

    public $cc;

    public function getCc(){
        return $this->cc;
    }


    public function setCc($cc){
        $this->cc = $cc;
        return $this;
    }

    public $subject;

    public function getSubject(){
        return $this->subject;
    }


    public function setSubject($subject){
        $this->subject = $subject;
        return $this;
    }

    public $attachments;

    public function getAttachments(){
        return $this->attachments;
    }


    public function setAttachments($attachments){
        $this->attachments = $attachments;
        return $this;
    }

    public $message;

    public function getMessage(){
        return $this->message;
    }


    public function setMessage($message){
        $this->message = $message;
        return $this;
    }

}