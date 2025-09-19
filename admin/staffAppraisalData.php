<?php include('checkAdmin.php');?>
<?php require_once('../Connections/cn.php'); ?>
<?php
//session_start();
//mysql_select_db($database_cn, $cn);
$user = $_GET['un'];
$period = urldecode($_GET['period']);
$query_cn = "select a.*, b.jobtitle from staff_tbl as a left join(jobs_tbl as b) on (a.jobcode=b.jobcode) where a.email='$user' ";
$rs = mysqli_query($cn, $query_cn) or die(mysql_error());
$row_rs = mysqli_fetch_assoc($rs);

$query_summary = "select * from kpi_summary_tbl where owner='$user' and period='$period'";
$sm = mysqli_query($cn, $query_summary) or die(mysql_error());
$row_sm = mysqli_fetch_assoc($sm);

$query_kpi = "select a.score,a.period, b.*, (a.score/b.weight) as grade from kpi_details_tbl as a left join (scorecard_tbl as b) on (a.kpiID=b.ID) where a.period='$period' and a.owner='$user' order by b.perspective ";
$kpi = mysqli_query($cn, $query_kpi) or die(mysql_error());
$row_kpi = mysqli_fetch_assoc($kpi);

$query360 = "select * from 360_tbl where level='".$row_rs['type_of_360']."'";
$rs360 = mysqli_query($cn, $query360) or die(mysql_error());
$row_360 = mysqli_fetch_assoc($rs360);
$total360 = mysqli_num_rows($rs360);

$queryMD = "select * from recommendation_tbl where period='$period' and owner='$user' and madeBy='MD'";
$rsMD=mysqli_query($cn, $queryMD) or die(mysql_error());
$row_mdrec=mysqli_fetch_assoc($rsMD);

$queryUH = "select * from recommendation_tbl where period='$period' and owner='$user' and madeBy<>'MD'";
$rsUH=mysqli_query($cn, $queryUH) or die(mysql_error());
$row_uhrec=mysqli_fetch_assoc($rsUH);


function getFinalScore($score, $total) {
	$calcScore = ($score/($total*5))*25;
	return $calcScore;
	}
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
		<script type="text/javascript" src="../jquery.min.js"></script>
<script type="text/javascript" src="../jquery.sparkline.min.js"></script>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table border="0" cellspacing="0" cellpadding="5" width=95%>
  <tr>
<td valign="top" bgcolor="#ebebeb">
<table border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td><table border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td><h2 class="demoHeaders"><?php echo $row_rs['fullname'];?><br />
          <span style="font-size:80%;"><?php echo $row_rs['jobtitle'];?></span></h2></td>
        <td valign="middle"><h1>}&nbsp;<?php echo $row_kpi['period']; ?></h1></td>
      </tr>
    </table>
      <table border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td align="right">Date of last Appraisal:</td>
          <td><?php echo $row_sm['last_appraisal_date'];?></td>
        </tr>
        <tr>
          <td align="right">Appraisal Date:</td>
          <td><?php echo $row_sm['appraisal_date'];?></td>
        </tr>
        <tr>
          <td align="right">Assessor:</td>
          <td><?php echo $row_sm['assessor'];?></td>
        </tr>
        <tr>
          <td align="right">Length of Service in CMS:</td>
          <td><?php echo $row_sm['employ_duration'];?></td>
        </tr>
        <tr>
          <td align="right">Tenure on Present Position:</td>
          <td><?php echo $row_sm['job_duration'];?></td>
        </tr>
      </table>
      <div class="tabs">
	<ul>
		<li style="background: #ffffff">General Information</li>
		<li>KPI Scoreboard</li>
		<li>Appraisal Report</li>
	</ul>
</div>
<div class=tab>
      <h3><a href="#">General Information</a></h3>
      <div>
        <table cellpadding="5" width=100%>
          <tr>
            <td colspan="2" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <?php
            $query_gpe = "select * from gpe_tbl order by ID asc";
			$gpe=mysql_query($query_gpe, $cn) or die(mysql_error());
			//$row_gpe=mysql_fetch_assoc($gpe);
			$i=1;
			while ($row_gpe=mysql_fetch_assoc($gpe)) {
			?>
            <tr><tD valign="top"><?php echo $i;?>. </tD><td><strong><?php echo $row_gpe['gpeID'];?></strong></td></tr>
            <tr>
              <td></td><td colspan=""  style="background: #ebebeb"><?php echo $row_sm['gpe'.$i];$i++;?></td></tr>
	    <tr><td>&nbsp;</td></tr>
<?php		
				}
			?>
        </table>
      </div></div>
	<div class=tab>
        <h3><a href="#">KPI Scoreboard</a></h3>
        <div>
          <table cellpadding="10" width=100% >
            <tr>
              <td valign="top"><table cellspacing="1" cellpadding="3" bgcolor="#999999">
                <tr bgcolor="#c0c0c0">
                  <td align="center">KPI</td>
                  <td align="center">&nbsp;</td>
                  <td align="center">WEIGHT</td>
                  <td align="center">SCORE</td>
                  <td align="center">MAX</td>
                </tr>
                <?php
		
		$good=0; $average=0; $poor=0; $p=-1; $overall=array(array());
		do {
			if ($kpiHead!=$row_kpi['perspective']) {
				$p++;
				$overall[$p][0]=$row_kpi['perspective'];
				?>
                <tr>
                  <td colspan="5" bgcolor="#FFFFFF">&nbsp;</td>
                </tr>
                <tr>
                  <td colspan="5" bgcolor="#EBEBEB"><strong><?php echo $row_kpi['perspective'];?></strong></td>
                </tr>
                <?php
				}
			?>
                <tr bgcolor="#ffffff">
                  <td><?PHP echo $row_kpi['initiative'];?></td>
                  <td><?php echo $row_kpi['rating'] ?></td>
                  <td><?php echo $row_kpi['weight'] ?></td>
                  <td align="right"><?php echo $row_kpi['score'] ?></td>
                  <td><?php echo $row_kpi['max'] ?></td>
                </tr>
                <?php
		//get rating performance
		$rating = intval($row_kpi['grade']);
		if ($rating<5) $poor++;
		if ($rating==5 || $rating==6) $average++;
		if ($rating>6) $good++;
		
		$overall[$p][1]+=$rating;
		$overall[$p][2]+=10;
			$kpiHead=$row_kpi['perspective'];
			$j++;
			} while ($row_kpi=mysql_fetch_assoc($kpi));
			?>
              </table></td>
            </tr>
          </table>
        </div>
	</div>
	</div>
        <div class=tab>
        <h3><a href="#">Appraisal Report</a></h3>
        <div>
        <table width=100%>
		
                <tr>
                  <td colspan="2"><h4>Score Summary</h4></td>
                </tr>
		<tr>
			<td >&nbsp;</td>
			<td rowspan=4 width=30%>
			<div id="performance" style="float: left;"></div>
			<div style="float: left; margin-left: 20px; margin-top: 15px;">
    <div>
        <div style="float: left; width: 10px; height: 10px; background: blue; margin-top: 2px; margin-right: 5px;"></div><div style="float: left; margin-right: 15px;">Good (7 and above)</div>
    </div>
    <br>
    <div>
        <div style="float: left; width: 10px; height: 10px; background: red; margin-top: 2px; margin-right: 5px;"></div><div style="float: left; margin-right: 15px;">Poor (4 and below)</div>
    </div>
    <br>
    <div>
        <div style="float: left; width: 10px; height: 10px; background: orange; margin-top: 2px; margin-right: 5px;"></div><div style="float: left; margin-right: 15px;">Average (5 and 6)</div>
    </div>
    </div>
			</td>
			<td rowspan=4 width="50%">
				<div>
				<div style="float: left; height: 100px;">
					<div style="height: 100px; margin-top: -7px;">100 -<br /><br><img src="../images/label-rating.png" /></div>
					<div style="text-align: right; ">0-</div>
				</div>
				<div id="bar" style="float: left; border-left: 1px #000000 solid; border-bottom: 1px #000000 solid; padding-right: 50px;"></div>
				</div>
				<br>
					<div id="keys"><strong><u>KEYS</u></strong></div>
				<div style="float: left; width: 100%; text-align: left;"><span style="margin-left: 100px;">perspectives</span></div>
			</td>
		</tr>
		<tr>
			<td valign=top>
			<table width=100%>
			<tr>
			  <td align="right"><strong>Actual Score:</strong></td>
			  <td id="score_sum"><?php echo $row_sm['score_summary'];?></td>
			</tr>
			<tr>
			  <td align="right"><strong>Maximum Score:</strong></td>
			  <td>100</td>
			</tr>
			<tr>
			  <td align="right"><strong>Approval Status: </strong></td>
			  <td><?php if ($row_sm['approval']=="") echo "<strong>PENDING</strong>"; else echo strtoupper($row_sm['approval']); ?></td>
			</tr>
			</table>
			</td>
		</tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr>
				<td colspan=3 valign="top" style="padding: 5px; background: #ebebeb;">
						<p><b>What specific strength has the employee
					    demonstrated on this job that should be
					    fully used during the next six months?</b> </p>
				<p><?php echo $row_sm['strengthDemonstrated']; ?></p></td>
		</tr>
		<tr>
				<td colspan=3 valign="top" style="padding: 5px; background: #ebebeb;">
						<p><b>List 2-3 areas (if applicable) in which the employee needs to improve his/her performance
during the next six months (gaps in knowledge or experience, skill development needs, behaviour modifications that affect job performance, etc).</b></p>
				<p><?php echo $row_sm['improveOn']; ?></p></td>
		</tr>
                <tr>
                  <td align="left" colspan="3" style="padding: 5px; background: #ebebeb;"><p><u><strong>Line Manager's Comments:</strong></u></p><p><?php echo $row_sm['comment']; ?></p></td>
                </tr>
              </table>
              <h4>TRAINING &amp; DEVELOPMENT</h4>
               <div id="result1"></div>
                  <script>
			$.post("postDevelopment.php", {owner: "<?php echo $user;?>", period: "<?php echo $period; ?>"}, function(data){$('#result1').html(data)});
			      </script>
              <h4>PERFORMANCE STANDARD FOR NEXT QUARTER</h4>
                <div id="result2"></div>
                  <script>
			$.post("postPerformance.php", {owner: "<?php echo $user;?>", period: "<?php echo $period;?>"}, function(data){$('#result2').html(data)});
			      </script>
              <h4>Overall Appraisal Summary</h4>
              <div>
              <?php
		$j=0;
		/*
		$query2 = "select distinct a.filledBy, b.fullname from appraisal360_tbl as a left join (staff_tbl as b) on (a.filledBy=b.email) where a.period='$period' and a.owner='$user' order by a.ID desc";
			$rs2 = mysql_query($query2, $cn);
			$row_rs2 = mysql_fetch_assoc($rs2);
			$colcount = mysql_num_rows($rs2);
			$x=0;
			do {
			$names[$x] = $row_rs2['filledBy'];
			$x++;
			} while ($row_rs2=mysql_fetch_assoc($rs2));
			
			do {
				$id360=$row_360['ID'];
				for ($i=0; $i<$colcount; $i++) { 
				$q="select score from appraisal360_tbl where owner='$user' and filledBy='$names[$i]' and period='$period' and 360ID='$id360'";
				$rst = mysql_query($q, $cn);
				$row_rst = mysql_fetch_assoc($rst);
				$score[$i]+=$row_rst['score'];
				} 				
			$sectionHead=$row_360['section'];
			$j++;
			} while ($row_360=mysql_fetch_assoc($rs360)); 
			

                        for ($i=0; $i<$colcount; $i++) { 
			$finalScore = number_format(getFinalScore($score[$i], $total360), 1); 
			$sumScores += $finalScore;
			 } 
			
                        $avgScore = $sumScores/$colcount; 
                        */
			$appScore = $row_sm['score_summary'];
			$finalScore = $appScore; //+ $avgScore;
			?>
		<table width="100%" border="0" cellspacing="0" cellpadding="5">
		<tr>
		  <td align="right" width=30%>Final Appraisal Score (100%)</td>
		  <td align="left"><?php echo $appScore; ?>%</td>
		</tr>
		<!---
		<tr>
		  <td>Final 360&deg; Score (25%)</td>
		  <td><?php echo $avgScore; ?>%</td>
		</tr>
		-->
		<tr>
		  <td align="right">Total Score</td>
		  <td align="left"><?php echo $finalScore; ?>%</td>
		</tr>
		<tr>
		  <td align="right" valign=top>Appraisal Class</td>
		  <td align="left" valign=top><?php 
		      if ($finalScore>=85) { $GRADE = "A";}
		      elseif ($finalScore>=70) { $GRADE = "B";}
		      elseif ($finalScore>=55) { $GRADE = "C";}
		      elseif ($finalScore>=45) { $GRADE = "D";}
		      else { $GRADE = "E"; }
		      ?>
	      <?php echo $GRADE; ?>
	      <p>
	      <?php switch ($GRADE) {
	      case "A": echo "The jobholder has, by far, exceeded the agreed goals. His/her contribution to the Company’s results is well above the level of good, well-motivated and able jobholders."; break;
	      case "B": echo "Always meets standards requirements and the jobholder has often exceeded the agreed goals. His/her contribution to the company’s result is above the level of good, well-motivated and able jobholders. "; break;
	      case "C": echo "Successfully achieves key requirements of position. The jobholder has achieved the agreed goals. His/her contribution to the company's results has been well up to expectations"; break;
	      case "D": echo "Performance has met some but not all standards. The jobholder has not fully met the agreed goals. His/her contribution to the company's result is below the level of good, well-motivated and able jobholders "; break;
	      case "E": echo "Not meeting performance requirements of position the jobholder has not met the agreed goals. To contribute to the company’s results, urgent improvements are needed"; break;
	      }?>
	      </p>
	      </td>
		</tr>
		<tr>
		  <td colspan=2><table width="90%" border="0" cellspacing="0" cellpadding="5">
		<tr>
		  <td colspan="3"><strong>KEY</strong></td>
		  </tr>
		<tr>
		  <td>A = EXCELLENT</td>
		  <td>B = GOOD</td>
		  <td>C = AVERAGE</td>
		  <td>D = NEEDS IMPROVEMENT</td>
		  <td>E = NOT ACCEPTABLE</td>
		</tr>
	      </table>
		<hr size="1" />
		<h3>Overall Recommendation</h3>
			    <div>
				<table border="0" cellspacing="0" cellpadding="5" width=100%>
				  <tr>
				    <td width=50% valign=top>
					<h4>Unit Head's Recommendation</h4>
					<p><u>Recommendation</u><br>
				    <?php echo $row_uhrec['recommendation'];?></p>
				    <p><u>Comments</u><br><?php echo $row_uhrec['comments'];?></p>
				    </td>
				  
				    <td valign=top>
					<h4>MD's Recommendation</h4>
					<p><u>Recommendation:</u><br>
				    <?php echo $row_mdrec['recommendation']; ?></p>
				    <p><u>Comments on recommendation:</u><br>
				    <?php echo $row_mdrec['comments'];?></p></td>
				  </tr>
				</table>
		</td>
		  </tr>
		</table>
        </div>
    </div>
	</div></div>
    </td>
  </tr>
</table>
</td></tr></table>
<script>
	$('.tabs li').click(function(){
		$('.tabs li').css({'background':'#ccc'});
		$(this).css({'background':'#ffffff'});
		var tab = ($('.tabs li').index($(this)));
		$('.tab').hide();
		$('.tab:eq('+tab+')').show();
		});
	$('.tab:eq(0)').show();
</script>

	      <script>
        $('#performance').sparkline([<?php echo "$good,$poor,$average"; ?>],{
            type: 'pie',
            width: '100',
            height: '100',
            tooltipFormat: '{{offset:offset}} ({{value}})',
            tooltipValueLookups: {'offset': {
            0:'Good',1:'Poor',2: 'Average'
            }
            }
            });
	<?php
	$tags="0: ' ',";
	$colorset=array('#ff0000','#00ff00','#0000ff','orange','#ffcc00','grey');
	for ($i=0; $i<count($overall); $i++) {
	$vals.=number_format(($overall[$i][1]*100/$overall[$i][2]), 2).",";
	$x=$i+1;
	$tags.="$i: '".$overall[$i][0]."',";
	$colors.="'$colorset[$i]',";
	}
	?>
	$('#bar').sparkline([<?php echo trim($vals, ","); ?>],{
		type: 'bar',
		barWidth: '35',
		height: '100',
		zeroColor: '#ffffff',
		zeroAxis: 'true',
		enableTagOptions: true,
		tagValuesAttribute: 'data-values',
		colorMap: [<?php echo trim($colors); ?>],
		tooltipFormat: '{{offset:offset}} ({{value}}%)',
		tooltipValueLookups: {'offset':{<?php echo trim($tags,","); ?>}},
		chartRangeMin: 0,
		chartRangeMax: 100
		});
	<?php
	for ($i=0; $i<count($overall); $i++){
		?>
		$('#keys').append("<div><div style='float: left; width: 10px; height: 10px; background: <?php echo $colorset[$i]?>; margin-top: 2px; margin-right: 5px;'></div><div style='float: left; margin-right: 15px;'><?php echo $overall[$i][0];?></div></div><br>");
		<?php
	}
	?>
    </script>
</body>
</html>