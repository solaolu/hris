<?php
session_start();
if (!isset($_SESSION['user__info'])) header('location:../index.php');
$user = (object) $_SESSION['user__info'];
$accessLevel=$user->accessLevel;
//echo "Level:".$accessLevel;
?>
<html>
    <head><title>Connect Marketing Online: HRIS Administrative Panel</title>
        <link href="../jquery.autocomplete.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />
    <script src="../jquery.min.js"></script>
    <script src="../jquery.autocomplete.min.js"></script>
    </head>
    <body>
        <table width="100%">
            <tr>
                <td colspan=2 bgcolor="#ffffff">
                    <img src="../logos/republicom.png" align=absmiddle width="200" /> <strong>HRIS ADMINISTRATIVE PANEL</strong>
                    <a href="logout.php" class=logoutbutton>logout</a>
                </td>
            </tr>
            <tr>
                <td width="300" valign=top >
                    <table width=100% cellpadding=5 cellspacing=1>
                        <tr><td class=searchbox align=center valign=top>
                           <table cellspacing=0 cellpadding=0><tr><td><input type=text id="search" class="inputbox" size=25 value=" employee name" /></td><td><a class=button href="">search</a> </td></tr></table>
                        </td></tr>
                        <?php switch ($accessLevel){
    case 1:
                        ?>
                        <tr><td align="center"><h3>HR MODULE</h3></td></tr>
                        <tr>
                            <td class="nav"><a  href="createuser.php" target="contentarea">create new user</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a  href="userMgt.php" target="contentarea">employee list</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a  href="createjobs.php" target="contentarea">job positions</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a  href="sendletter.php" target="contentarea">send letter</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a  href="createappraisals.php" target="contentarea">appraisal periods</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a  href="listScorecards.php" target="contentarea">scorecard management</a></td>
                        </tr>
                        <!--<tr>
                            <td class="nav"><a  href="list360Appraisals.php" target="contentarea">360&deg; appraisal management</a></td>
                        </tr>-->
                        <tr>
                            <td class="nav"><a  href="listGPE.php" target="contentarea">general appraisal questions</a>    </td>
                        </tr>
                        <tr>
                            <td class="nav"><a  href="settasks.php" target="contentarea">set weekly task(s)</a></td>
                        </tr>
                        <!--<tr>
                            <td class="nav"><a  href="listtimesheets.php" target="contentarea">view today's timesheets</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a  target="contentarea" href="listtimesheets.php?thedate=<?php echo $previousday; ?>">previous day's timesheets</a>    </td>
                        </tr>-->
                        <tr>
                            <td class="nav"><a  target="contentarea" href="uploadleaveschedule.php?m=individual">upload annual leave schedule</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a  target="contentarea" href="leaveschedule.php?m=individual">view annual leave schedule (individual)</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a  target="contentarea" href="leaveschedule.php?m=department">view annual leave schedule (department)</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a   target="contentarea" href="listleaverequests.php">leave requests</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a   target="contentarea" href="reset.php">reset annual schedule</a></td>
                        </tr>
                        <tr>
                            <td class=nav><a target="contentarea" href="payslip.php">manage salaries</a></td>
                        </tr>
                        <tr>
                        <td class="nav"><a class="nav" href="attendance.php" target="contentarea">internal training attendance</a></td>
                        </tr>
                        <tr>
                            <td class=nav><a href="listtrainingrequests.php" target="contentarea">training requests</a></td>
                        </tr>
                        <?php break;
    case 2:
                        ?>
                        <tr><td class=nav align="center"><h3>FINANCE MODULE</h3></td></tr>
                        <tr>
                            <td class="nav"><a href="payables.php" target="contentarea">download latest payables</a></td>
                        </tr>
                        <?php break; 
    case 3:
                        ?>
                        <tr><td class=nav align="center"><h3>PROCUREMENT MODULE</h3></td></tr>
                        <tr>
                            <td class=nav><a href="procurementapplications.php" target="contentarea">supplier applications</a> </td>
                        </tr>
                        <!--<tr>
                            <td class="nav"><a  href="supplierscorecards.php" target="contentarea">supplier scorecards</a></td>
                        </tr>-->
                        <tr>
                            <td class=nav ><a href="supplierslist.php" target="contentarea">suppliers list</a></td>
                        </tr>
                        <tr>
                            <td class=nav ><a href="supplierbrief.php" target="contentarea">supplier briefs</a></td>
                        </tr>
                        <tr>
                            <td class=nav ><a href="jobcompletion.php" target="contentarea">job completion reports</a></td>
                        </tr>
                        <tr>
                            <td class=nav ><a href="supplierappraisallist.php" target="contentarea">project evaluation report</a></td>
                        </tr>
                        <tr>
                        </tr>
                        <?php break; 
    case 4:
                        ?>
                        <tr><td class=nav align="center"><h3>INVENTORY MODULE</h3></td></tr>
                        <tr>
                            <td class="nav"><a  href="inventoryrequests.php" target="contentarea">inventory requests</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a  href="listinventoryitems.php" target="contentarea">inventory items</a></td>
                        </tr>
                        <tr>
                        </tr>
                        <?php break;  
    case -1:
                        ?>
                        <tr><td class=nav align="center"><h3>SUPER ADMIN</h3></td></tr>
                        <tr>
                            <td class=nav><a href="start.php?p=1" target="contentarea">employee management</a></td>
                        </tr>
                        <tr>
                        </tr>
                        <?php break; 
    case 5:                   
                        //FORCE companyID to 8 by default
                        $_SESSION['user__info']['companyID']=8;
                        ?>
                        <tr><td align="center"><h3>SALES FORCE MODULE</h3></td></tr>
                        <tr>
                            <td class="nav"><a  href="createuser.php" target="contentarea">create new user</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a  href="userMgt.php" target="contentarea">employee list</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a  href="createjobs.php" target="contentarea">job positions</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a  href="createappraisals.php" target="contentarea">appraisal periods</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a  href="listScorecards.php" target="contentarea">scorecard management</a></td>
                        </tr>
                        <!--<tr>
                            <td class="nav"><a  href="list360Appraisals.php" target="contentarea">360&deg; appraisal management</a></td>
                        </tr>-->
                        <tr>
                            <td class="nav"><a  href="listGPE.php" target="contentarea">general appraisal questions</a>    </td>
                        </tr>
                        <!--<tr>
                            <td class="nav"><a  href="settasks.php" target="contentarea">set weekly task(s)</a></td>
                        </tr>-->
                        <tr>
                            <td class="nav"><a  target="contentarea" href="uploadleaveschedule.php?m=individual">upload annual leave schedule</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a  target="contentarea" href="leaveschedule.php?m=individual">view annual leave schedule (individual)</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a  target="contentarea" href="leaveschedule.php?m=department">view annual leave schedule (department)</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a   target="contentarea" href="listleaverequests.php">leave requests</a></td>
                        </tr>
                        <tr>
                            <td class="nav"><a   target="contentarea" href="reset.php">reset annual schedule</a></td>
                        </tr>
                        <tr>
                            <td class=nav><a target="contentarea" href="listPaysliprequests.php">Payslip Requests</a></td>
                        </tr>
                        <tr>
                            <td class=nav><a href="listtrainingrequests.php" target="contentarea">training requests</a></td>
                        </tr>
                        <tr>
                            <td class=nav><a href="listvacancies.php" target="contentarea">Vacancies</a></td>
                        </tr>
                        <?php break;
                            } ?>
                    </table>
                </td>
                <td valign=top>
                <iframe height="750" style="min-height: 750px;" width="99%" scroll=auto frameborder=0 name="contentarea" >
                    
                </iframe>
                </td>
            </tr>
        </table>
        <script>
            $("#search").click(function (){
			if ($(this).val()==$(this).prop('defaultValue')) $(this).val('');
						 });
			$("#search").blur(function (){
			if ($(this).val()=='') $(this).val($(this).prop('defaultValue')) ;
                        });
            $('#search').autocomplete('autocomplete.php', {
			minChars: 2
			 });
            
            $('.button').click(function(){
                alert($('#search').val())
                });
            
        </script>
    </body>
</html>