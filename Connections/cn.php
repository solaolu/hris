<?php

//quick legacy fix
include('../classes/dao.php');

$db = new DAO();
$conn = $db->connect();
$cn=$conn;

function showView($tbl, $skip, $template, $profileData){
    global $cn;
    $query="SHOW FULL COLUMNS FROM $tbl";
    //"select column_name, data_type, comments from information_schema.COLUMNS where TABLE_NAME='$tbl'";
    $rs = mysqli_query($cn, $query) or die(mysqli_error($cn));
    $colcount=0;
    echo "<table cellpadding=4 width=100% cellspacing=0>";
    $rowcount=0;
    while ($cols=mysqli_fetch_assoc($rs)){
        $multi=false;
        $label = getPhrase($cols['Field']);
        $colname=$cols['Field'];
        $coltype=$cols['Type'];
        
        if ($cols['Comment']!="") {
            $theextra=explode("||", $cols['Comment']);
            foreach ($theextra as $value) {
                $cat=explode(":", $value);
                    
                    if ($cat[0]=="desc") {
                        $label=$cat[1];                
                    }
                    
                    if ($cat[0]=="extra") {
                        if (strpos($coltype, 'varchar', 0)===false) {
                          $label.="<br><small><em>(".$cat[1].")<em></small>";    
                        } else {
                          $label.="|".$cat[1]; 
                        }
                    }
            }

        }
        
        if ($label!="ID" && $label!="owner" && (strpos($skip, "`".$cols['Field']."`")===false)) {
            if (!is_numeric($template[$rowcount]) ) {
                echo "<tR><td colspan=".max($template)."><h4>$template[$rowcount]</h4><hr size=1 /></td></tr>";
             $rowcount++;
            }
            if ($colcount==0 || $coltype=="tinyint(1)") echo "<tr>";
            echo "<td valign=middle";
            if ($template[$rowcount]==1) echo " colspan='".max($template)."'";
            echo " >";
            echo "<div style='float:left; width:130px; text-transform: capitalize; background-color: #ccc; text-align: right; padding: 5px;' ><strong>".getPhrase($label).":</strong></div> <div style='float: left; padding:5px; background-color:#fff; width: 150px;'>".$profileData[$colname]."&nbsp;</div>";
            echo "</td>";
            if ($colcount==($template[$rowcount]-1) || $coltype=="tinyint(1)") {echo "</tr>"; $colcount=0; $rowcount++;}else {$colcount++;}
        }
        
    }
    echo "</table>";
    ?>
    <?php
}

function getPhrase($theword){
    $re= '/
    (?<=[a-z])
    (?=[A-Z])
    /x';
    $a=preg_split($re, $theword);
    $newWord=implode($a, " ");
    return $newWord;
}

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

?>