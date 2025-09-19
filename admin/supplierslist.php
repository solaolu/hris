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
$extra=($_GET['cat']!="")?"where category='".urldecode($_GET['cat'])."'":"";
$rs=mysqli_query($cn, "select * from suppliers_tbl $extra order by ID desc limit $start, $limit") or die(mysqli_error($cn));

$stages=3;
$targetpage="supplierslist.php";
$total_pages=mysqli_num_rows(mysqli_query($cn, "select ID from suppliers_tbl $extra"));

$paginate=paginate($total_pages, $stages, $page, $limit, $targetpage);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script src="../jquery.min.js"></script>
<script>
   function setScorecard(obj, ID){
    var x=Math.random();
    //alert(ID);
    cID=$('#ID').val();
    $('#form1').replaceWith('<a href=# onclick="setScorecard(this, cID)">Set Scorecard</a>');
    $(obj).parent('div').load('setscorecard.php?x='+x+'&id='+ID);
    
    }
    
    function updateScorecard(obj){
        var x=Math.random();
        $.post('setscorecard.php?x='+x, $('#form1').serialize(), function(data){$(obj).html(data)});
    }
    
    function jumpto(category){
        location.href='supplierslist.php?cat='+category;
    }
</script>
</head>
<body>
    <div style="padding: 30px;" >
    <h3>SUPPLIERS LIST</h3>
    <p><?php echo $_GET['msg']; ?></p>
    <select onchange="jumpto(this.value)">
        <option value="">Load by Category</option>
        <?php
        $x=mysqli_query($cn, "select distinct category from suppliers_tbl");
        while ($rx=mysqli_fetch_assoc($x)){
            ?>
            <option value="<?php echo urlencode($rx['category']); ?>"><?php echo $rx['category']; ?></option>
            <?php
        }
        ?>
    </select>
    <table cellpadding=5>
    <?php
    if (!mysqli_num_rows($rs)) echo "<tr><td>No suppliers found.</td></tr>";
    while ($row=mysqli_fetch_assoc($rs)) {
        ?>
        <tr>
            <td><?php echo $row['supplierName']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['contactPerson']; ?></td>
            <?php if ($row['flagged']) { ?>
            <td><a href="flag.php?id=<?php echo $row['ID']; ?>">EDIT/REMOVE FLAG</a></td>
            <?php } else { ?>
            <td><a href="flag.php?id=<?php echo $row['ID']; ?>">FLAG</a></td>
            <?php } ?>
            <td><div><a href="#" onclick="setScorecard(this, '<?php echo $row['ID']; ?>')">Set Scorecard</a></div></td>
        </tr>
        <?php
        }
        ?>
    </table>
    <?php echo "<div>".$paginate."</div>"; ?>
    </div>
</body>
</html>