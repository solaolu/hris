<?php

class Email
{
    public function __construct(){
        //ini_set("SMTP", "smtp.uptimemail.com");
    }

    public function send($mailbody){
        $file = $mailbody->attachment;
        $mailto = $mailbody->to;
        $from_mail = $mailbody->from;
        $cc = $mailbody->cc;
        $bcc = $mailbody->bcc;
        $subject=$mailbody->subject;
        $body=$mailbody->message;

        if ($file!=null) {
            $filename = pathinfo($file, PATHINFO_BASENAME);
            $file_size = filesize($file);
            $handle = fopen($file, "r");
            $content = fread($handle, $file_size);
            fclose($handle);
            $content = chunk_split(base64_encode($content));
            $name = basename($file);
        }

        $uid = md5(uniqid(time())); 

        $eol = PHP_EOL;

        // Basic headers
        $header = "From: ".$from_mail.$eol;
        //$header .= "Reply-To: ".$replyto.$eol;
        if ($cc!=null) $header.= "Cc: ".$cc.$eol;
        if ($bcc!=null) $header.= "Bcc: ".$bcc.$eol;
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"";

        // Put everything else in $message
        $message = "--".$uid.$eol;
        $message .= "Content-Type: text/html; charset=ISO-8859-1".$eol;
        $message .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
        $message .= $body.$eol;
        $message .= "--".$uid.$eol;
        if (!is_null($file)){
            $message .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol;
            $message .= "Content-Transfer-Encoding: base64".$eol;
            $message .= "Content-Disposition: attachment; filename=\"".$filename."\"".$eol;
            $message .= $content.$eol;
            $message .= "--".$uid."--";
        }

        if (mail($mailto, $subject, $message, $header)) {
            return true;
        } else {
            return false;
        }
    }
    
    public function send__($mailbody) {
        $file = $mailbody->attachment;
        $mailto = $mailbody->to;
        $from_mail = $mailbody->from;
        $cc = $mailbody->cc;
        $bcc = $mailbody->bcc;
        //$from_name;
        //$replyto;
        $subject=$mailbody->subject;
        $message=$mailbody->message;

        if ($file!=null) {
            $filename = pathinfo($file, PATHINFO_BASENAME);
            $file_size = filesize($file);
            $handle = fopen($file, "r");
            $content = fread($handle, $file_size);
            fclose($handle);
            $content = chunk_split(base64_encode($content));
            $name = basename($file);
        }

        $uid = md5(uniqid(time()));    
        $header = "From: $from_mail\r\n";
        if ($cc!=null) $header.= "Cc: $cc\r\n";
        //$header .= "Reply-To: ".$replyto."\r\n";
        if ($bcc!=null) $header.= "Bcc: $bcc\r\n";
        $header .= "MIME-Version: 1.0\r\n";

        if ($file!=null){
            $header .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n"; // use different content types here
            $header .= "Content-Transfer-Encoding: base64\r\n";
            $header .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
            $header .= $content."\r\n\r\n";
            $header .= "--".$uid."--";
        } else {
            $header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
            //$header .= "This is a multi-part message in MIME format.\r\n";
            //$header .= "--".$uid."\r\n";
            //$header .= "Content-type:text/plain; charset=iso-8859-1\r\n";
            $header .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
            $header .= $message."\r\n\r\n";
            //$header .= "--".$uid."\r\n";
        }

        if (mail($mailto, $subject, "", $header)) {
            return true;
        } else {
            return false;
        }
    }
}

class MailBody
{
    public $from;
    public $to;
    public $cc;
    public $bcc;
    public $message;
    public $subject;
    public $attachment;
}

?>