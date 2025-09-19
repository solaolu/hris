<?php
require_once('../Connections/cn.php');
mysqli_select_db($database_cn);
autocomplete();

function autocomplete_format($results) {
    foreach ($results as $result) {
        echo $result[0] . '|' . $result[1] . "\n";
    }
}	
	
function autocomplete(){
	
	$results = array();
if (isset($_GET['q'])) {
    $q = mysqli_real_escape_string(strtolower($_GET['q']));
    if ($q) {
	
       // $query="select distinct company, alias, asset from (prices as a) left outer join (pricestorica as b) on a.company=b.asset where company like '$q%' or alias like '$q%'";
	$query = "select distinct fullname, email from staff_tbl where fullname like '%$q%' or email like '%$q%'";
	$rs=mysqli_query($cn, $query) or die(mysqli_error($cn));
	$count = mysqli_num_rows($rs);
	if ($count) {
		$i=0;
		while ($i<$count) {
		$value=mysqli_result($rs, $i, 'email');
		$key=mysqli_result($rs, $i, 'fullname');
		//if ($key=="")
		//$key=$value;
		$results[] = array($key, $value);
		$i++;
		}
		}
    }
}

/*
 * Output format
 */
$output = 'autocomplete';
if (isset($_GET['output'])) {
    $output = strtolower($_GET['output']);
}

/*
 * Output results
 */
if ($output === 'json') {
    echo json_encode($results);
} else {
    echo autocomplete_format($results);
}
	
	}
?>