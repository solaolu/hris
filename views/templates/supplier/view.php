<?php 
require_once('../../../classes/dao.php');
$db = new DAO();
$cn = $db->connect();

if (isset($_GET['id']))
if (!is_nan($_GET['id'])) {
    $id=$_GET['id'];
    
    $sql="select * from supplierNotification_tbl where ID=$id";
    $rows = $db->getData($sql);
    
    if (count($rows)){
        $row = $rows[0];
        $tbl=null;
        $brieftype=$row['category'];
        switch ($brieftype){
                case "EVEN":
                    $tbl = "eventRequest_tbl";
                    break;
                case "LOGI": 
                    $tbl="logisticsRequest_tbl";
                    break;
                case "LOGO": 
                    $tbl="logoRequest_tbl";
                    break;
                case "RESEA": 
                    $tbl="researchRequest_tbl";
                    break;
                case "DEEJ": 
                    $tbl="djRequest_tbl";
                    break;
                case "LIGH": 
                    $tbl="lightRequest_tbl";
                    break;
                case "PHOT": 
                    $tbl="photographyRequest_tbl";
                    break;
                case "VIDE": 
                    $tbl="videographyRequest_tbl";
                    break;
            }
            if (!is_null($tbl)) {
                $brief = $db->getData("select * from $tbl where ID=".$row['requestID']);
                $template = array(2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,2,1,1,2,1,2,1,2,3,4,2,1,1,1,2,2);
                $skip = "`ID`, `supplier1`, `supplier2`, `supplier3`, `requestDate`, `isDeleted`";
                //var_dump($brief);
                showView($tbl, $skip, $template, $brief[0]);
            }
    }
}

function showView($tbl, $skip, $template, $profileData){
    global $cn;
    $query="SHOW FULL COLUMNS FROM $tbl";
    //"select column_name, data_type, comments from information_schema.COLUMNS where TABLE_NAME='$tbl'";
    $rs = mysqli_query($cn, $query) or die(mysqli_error($cn));
    $colcount=0;
    echo "<table cellpadding=4 width=100% cellspacing=0 class='table table-responsive table-striped'>";
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
            echo "<div style='float:left; width:130px; text-transform: capitalize; text-align: right; padding: 5px;' ><strong>".getPhrase($label).":</strong></div> <div style='float: left; padding:5px; width: 150px;'>".$profileData[$colname]."&nbsp;</div>";
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


?>
<p>&nbsp;</p>
<h4>Supplier's Response</h4>
<hr size=1 />
<form id="briefQuoteForm">
       <input type="hidden" name="ID" value="<?php echo $id; ?>" />
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label>Quote for this brief:</label>
                <input type="text" class="form-control" name="quote" size=40 />
            </div>
        </div>
        <div class="col-md-6 col-sm-6">
            <div class="form-group">
                <label>Comment:<br /><small>You can add details of additional rates or other information here</small></label>
                <textarea class="form-control" cols=50 rows=10 name="comment"></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <a class="btn btn-lg btn-success" onclick="sendQuote()">Submit Quote</a>
        </div>
</form>