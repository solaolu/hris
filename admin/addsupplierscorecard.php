<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="style.css" rel="stylesheet" type="text/css" />
<script src="../jquery.min.js" language="javascript" ></script>
<script>
    function addKPI(){
        x=Math.random();
        $.post('addKPI.php?x='+x, $('#form1').serialize(), function(data){$('#kpibox').html(data);})
    }
    
    function loadKPI(){
        var x=Math.random();
        $('#kpibox').load('addKPI.php?x='+x);
    }
    
    function addMetric(){
        var x=Math.random();
        $.post('addMetrics.php?x='+x, {'metric':$('#metric').val(), 'metricWeight':$('#metricweight').val()}, function(data){$('#metricbox').html(data);})
    establishAutoclear();
    }
    
    function establishAutoclear(){
  $(".autoclear").click(function (){
			if ($(this).val()==$(this).prop('defaultValue')) {
                          if ($(this).attr('autofill')=='') $(this).val(''); else $(this).val($(this).attr('autofill')); 
                          };
						 });
			$(".autoclear").blur(function (){
			if ($(this).val()=='') $(this).val($(this).prop('defaultValue')) ;
					 });
}
    
</script>
</head>
<body>
    <div style="padding: 30px;" >
    <h3>NEW SUPPLIER SCORECARD</h3>
    <form id="form1">
        <p>New Scorecard Name: <input type="text" name="scorecardName" id="scorecardName" /></p>
    <p>Available Metrics:</p>
    <div id="metricbox" style="float: left; width: 100%; height: 200px; overflow-y: scroll; ">
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
            <input type="text" name="metric" id="metric" class="autoclear" value="Metric" />&nbsp;<input type="text" class="autoclear" name="metricWeight" id="metricweight" value="Weight" /> &nbsp; <a href=# onclick="addMetric()" >ADD METRIC</a>

    </div>
    <p>&nbsp;</p>
    <div>
    <p><strong>KPIs: </strong><a href="#" onclick="loadKPI();">Set KPI's</a>
    <div id="kpibox"></div>
    </div>
    </form>
    <p>&nbsp;</p>
    </div>
    <script>
        establishAutoclear();
    </script>
</body>
</html>