<div class="row">
<?php

function draw_calendar($month,$year){

	/* draw table */
	$calendar = '<table cellpadding="5" cellspacing="0" class="table-bordered table-striped">';
        /* Calendar month */
        $months = array("january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december");
        $calendar .= "<tr class='calendar-row'><td colspan=7 class='bg-dark'><strong>".strtoupper($months[($month-1)])."</strong></td></tr>";
	/* table headings */
	$headings = array('Su','Mo','Tu','We','Th','Fr','Sa');
	$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

	/* days and weeks vars now ... */
	$running_day = date('w',mktime(0,0,0,$month,1,$year));
	$days_in_month = date('t',mktime(0,0,0,$month,1,$year));
	$days_in_this_week = 1;
	$day_counter = 0;
	$dates_array = array();

	/* row for week one */
	$calendar.= '<tr class="calendar-row">';

	/* print "blank" days until the first of the current week */
	for($x = 0; $x < $running_day; $x++):
		$calendar.= '<td class="calendar-day-np"> </td>';
		$days_in_this_week++;
	endfor;

	/* keep going with days.... */
	for($list_day = 1; $list_day <= $days_in_month; $list_day++){
    
        /* add in the day number */
        $theday = "D-".$list_day."-".$month; //$list_day."/".$month."/".$year;
		$calendar.= "<td id='$theday' class='calendar-day'>";
        $calendar.= "<div  class='day-number'>".$list_day."</div>";//checkday($theday)

			/** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
			//$calendar.= str_repeat('<p> </p>',2);
			
		$calendar.= '</td>';
		if($running_day == 6):
			$calendar.= '</tr>';
			if(($day_counter+1) != $days_in_month):
				$calendar.= '<tr class="calendar-row">';
			endif;
			$running_day = -1;
			$days_in_this_week = 0;
		endif;
		$days_in_this_week++; $running_day++; $day_counter++;
    }

	/* finish the rest of the days in the week */
	if($days_in_this_week < 8):
		for($x = 1; $x <= (8 - $days_in_this_week); $x++):
			$calendar.= '<td class="calendar-day-np"> </td>';
		endfor;
	endif;

	/* final row */
	$calendar.= '</tr>';

	/* end the table */
	$calendar.= '</table>';
	
	/* all done, return result */
	return $calendar;
}

for ($i=1;$i<=12;$i++ ){
    ?>
    <div class="col-md-3" style="margin-top: 25px;">
        <?php echo draw_calendar($i, date("Y")); ?>
    </div>
    <?php
}
?>
</div>