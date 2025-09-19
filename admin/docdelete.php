<?php require_once('../Connections/cn.php');
mysqli_select_db($database_cn);
$id = $_GET['id'];
$tbl = "documents_tbl";
$un = $_GET['un'];
$href = "documents.php?msg=Document deleted successfully!&un=$un";
if (isset($_GET['extra'])) $href .= "&".$_GET['extra'];

$rs=mysqli_query($cn, "select * from documents_tbl where ID=$id");
if (mysqli_num_rows($rs)) $file="../".mysqli_result($rs, 0, 'filename');

$query="update $tbl  set isDeleted=1  where ID=$id";
mysqli_query($cn, $query) or die(mysqli_error($cn));	
	
        if (mysqli_affected_rows) {
            if ($file!="")
            if (file_exists($file)) unlink($file);
        }
        
header("location: $href");	
?>