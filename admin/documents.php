<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');

include('paginate.php');

    $limit = 20;	
    $page = mysqli_escape_string($_GET['page']);
    if($page){
		$start = ($page - 1) * $limit; 
	}else{
		$start = 0;	
    }
    
$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$user=$_GET['un'];
$msg=$_GET['msg'];

if ((isset($_POST["MM_Insert"])) && ($_POST["MM_Insert"] == "form1")) {
  
  $userid=explode("@", $user);
    //file management
    if (isset($_FILES['document'])){
    $filename=$_FILES['document']['name'];
    $extpos=strrpos($filename, ".");
    $ext = substr($filename, $extpos);
    $attachment="DOC-"."_$userid[0]_".rand(3000, 900000).$ext;
    $attachmentdir='documents/'.$attachment;
    move_uploaded_file($_FILES['document']['tmp_name'], "../$attachmentdir");
    
    //insert into DB
    $title=$_POST['title'];
    mysqli_query($cn, "insert into documents_tbl (title, filename, owner, uploadedBy) values ('$title', '$attachmentdir', '$user', 'admin' )");
  
  $msg="New document successfully uploaded!";
  }
}
    

$rs=mysqli_query($cn, "select a.*, b.fullname from staff_tbl as b left join documents_tbl as a on a.owner=b.email where email='$user' order by a.ID desc limit $start, $limit") or die(mysqli_error($cn));

$stages=3;
$targetpage="documents.php";
$total_pages=mysqli_num_rows(mysqli_query($cn, "select ID from documents_tbl where owner='$user'"));

$paginate=paginate($total_pages, $stages, $page, $limit, $targetpage);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script src="../jquery.min.js"></script>

</head>
<body>
    <div style="padding: 30px;" >
    <h3><?php
    $row=mysqli_fetch_assoc($rs);
    echo strtoupper($row['fullname']); ?>'S DOCUMENTS</h3>
    <p><?php echo $msg; ?></p>
<p>&nbsp;</p>
Upload a new document for <?php echo $row['fullname']; ?>
<form action="<?php echo $editFormAction; ?>" method=post enctype="multipart/form-data" >
    Document Title: <input type="text" name="title" /><Br>
    <input type="file" name="document" /><br>
    <input type=hidden name="MM_Insert" value="form1" />
    <input type="hidden" value="<?php echo $user; ?>" name="user" />
    <input type="submit" value="Upload Document" />
</form>
<p>&nbsp;</p>
    <table cellpadding=5>
    <?php
    if ($row['filename']=="") echo "<tr><td>No documents found.</td></tr>"; else 
     do {
        ?>
        <tr>
            <td><?php echo $row['title']; ?></td>
            <td><a href="../<?php echo $row['filename']; ?>" target="_blank" ><?php echo $row['filename']; ?></a></td>
            <td><div><a href="docdelete.php?id=<?php echo $row['ID']; ?>&un=<?php echo $user; ?>" >delete document</a></div></td>
        </tr>
        <?php
        } while ($row=mysqli_fetch_assoc($rs))
        ?>
    </table>
    <?php echo "<div>".$paginate."</div>"; ?>
    </div>
</body>
</html>