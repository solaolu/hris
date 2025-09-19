<?php
require_once('../Connections/cn.php');
?>
        <table>
        <tr>
            <td>METRIC</td>
            <td>KPI</td>
            <td>WEIGHT</td>
            <td>MEASUREMENT</td>
        </tr>    
        <tr><td>
            <select name=metricID >
            <?php
            $m=mysqli_query($cn, "select * from supplierMetrics_tbl");
            while ($mrow=mysqli_fetch_assoc($m)){
            ?>
            <option value="<?php echo $mrow['ID']; ?>"><?php echo $mrow['metric']." (".$mrow['weight'].")"; ?></option>
            <?php } ?></select>
        </td>
            <td><input type="text" name="kpi"></td>
            <td><input type="text" name="weight" size=7 /></td>
            <td><input type="text" name="measurement" /></td>
       <td><p><a href="#" onclick="addKPI();" >ADD KPI</a></p></td></tr>
        <?php
        $scorecardName=$_POST['scorecardName'];
        
        if (isset($scorecardName)) {
            mysqli_query($cn, "insert into supplierKPIs_tbl (scorecard, metricID, kpi, weight, measurement) values ('$scorecardName', '".$_POST['metricID']."','".$_POST['kpi']."','".$_POST['weight']."','".$_POST['measurement']."')");
        }
        
        $rs=mysqli_query($cn, "select a.*, b.metric from supplierKPIs_tbl as a left join supplierMetrics_tbl as b on a.metricID=b.ID where scorecard='$scorecardName'");
        while ($row=mysqli_fetch_assoc($rs)){
            ?>
            <tr>
                <td><?php echo $row['metric']; ?></td>
                <td><?php echo $row['KPI']; ?></td>
                <td><?php echo $row['weight']; ?></td>
                <td><?php echo $row['measurement']; ?></td>
            </tr>
            <?php
        }
        ?>
        </table>