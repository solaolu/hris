<?php
require_once('../Connections/cn.php');
?>
        <?php
        $metric=$_POST['metric'];
        $metricWeight=$_POST['metricWeight'];
        if (isset($metric) && $metric!="Metric" && $metric!="" && isset($metricWeight) && $metricWeight!="Weight" && $metricWeight!="")  {
            mysqli_query($cn, "insert into supplierMetrics_tbl (metric, weight) values ('$metric','$metricWeight')");
        echo "<p>Metric Added!</p>";
        }
        
        ?>
        <table cellpadding=5 border=1 bordercolor="#000000" cellspacing=0 align=left>
    <?php
    $rs=mysqli_query($cn, "select * from supplierMetrics_tbl");
    if (!mysqli_num_rows($rs)) echo "<tr><td>No metrics found.</td></tr>"; else {?>
            <tr>
            <th>Metric</th>
            <th>Weight</th>
        </tr>
    <?php }
    while ($row=mysqli_fetch_assoc($rs)) {
        ?>
        <tr>
            <td><?php echo $row['metric']; ?></td>
            <td><?php echo $row['weight']; ?></td>
        </tr>
        <?php
        }
        ?>
    </table>
            <input type="text" name="metric" id="metric" class="autoclear" value="Metric" />&nbsp;<input type="text" name="metricWeight" class="autoclear" id="metricweight" value="Weight" /> &nbsp; <a href=# onclick="addMetric()" >ADD METRIC</a>