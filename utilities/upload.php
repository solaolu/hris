<?php 

//file management
$dir = $_GET["dir"];

if (isset($_GET['field']) && isset($_GET['folder'])){
    $field = $_GET['field'];
    $folder = $_GET['folder'];
}

$dir();

function memos(){
    if (isset($_FILES['attachment'])){
        $filename=$_FILES['attachment']['name'];
        $extpos=strrpos($filename, ".");
        $ext = substr($filename, $extpos);
        $attachment="ATTCH-".rand(3000, 900000).$ext;
        $attachmentdir='uploads/memos/'.$attachment;
        if (move_uploaded_file($_FILES['attachment']['tmp_name'], "../".$attachmentdir)) echo $attachmentdir;
    }
}

function handovers(){
    if (isset($_FILES['handoverNote'])){
        $filename=$_FILES['handoverNote']['name'];
        $extpos=strrpos($filename, ".");
        $ext = substr($filename, $extpos);
        $attachment="HoN-".rand(3000, 900000).$ext;
        $attachmentdir='uploads/handovers/'.$attachment;
        if (move_uploaded_file($_FILES['handoverNote']['tmp_name'], "../".$attachmentdir)) echo $attachmentdir;
    }
}

function upload(){
    global $field;
    global $folder;
    
    if (isset($_FILES)){
        $filename=$_FILES["$field"]['name'];
        $extpos=strrpos($filename, ".");
        $ext = substr($filename, $extpos);
        $attachment="file-".rand(3000, 900000).$ext;
        $attachmentdir="uploads/$folder/$field/".$attachment;
        
        if (move_uploaded_file($_FILES["$field"]['tmp_name'], "../".$attachmentdir)) echo $attachmentdir;
    }
}


?>