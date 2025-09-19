<?php

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
            <tr><td colspan=2 bgcolor="#ffffff"><img src="../images/logo.gif" align=absmiddle /> <strong>HRIS ADMINISTRATIVE PANEL</strong>
            <a href="logout.php" class=logoutbutton>logout</a>
            </td></tr>
            <tr>
                <td width="300" >
                    <table width=100% cellpadding=5 cellspacing=1>
                        <tr><td class=searchbox align=center>
                           <table cellspacing=0 cellpadding=0><tr><td><input type=text id="search" class="inputbox" size=25 value=" employee name" /></td><td><a class=button href="">search</a> </td></tr></table>
                        </td></tr>
                        <tr><td class=nav><a href="start.php?p=1" target="contentarea"><img src="../images/profile.png" align=absmiddle border=0 hspace=5 />employee management</a></td></tr>
                        <tr><td class=nav><a href="start.php?p=2" target="contentarea"><img src="../images/appraise.png" align=absmiddle border=0 hspace=5 />Staff Appraisals</a></td></tr>                        
                        <tr><td class=nav><a href="start.php?p=3" target="contentarea"><img src="../images/time.png" align=absmiddle border=0 hspace=5 />task management</a></td></tr>
                        <tr><td class=nav><a href="start.php?p=4" target="contentarea"><img src="../images/leave.png" align=absmiddle border=0 hspace=5 />leave management</a></td></tr>
                        <tr><td class=nav><a href="start.php?p=5" target="contentarea"><img src="../images/development.png" align=absmiddle border=0 hspace=5 />training management</a></td></tr>
                        <tr><td class=nav><a href="start.php?p=6" target="contentarea"><img src="../images/in.png" align=absmiddle border=0 hspace=5 />inventory management</a></td></tr>
                        <tr><td class=nav><a href="start.php?p=7" target="contentarea"><img src="../images/inventory.png" align=absmiddle border=0 hspace=5 />procurement management</a></td></tr>                    
                        <tr><td class=nav><a href="configuration.php?p=8" target="contentarea"><img src="../images/settings.png" align=absmiddle border=0 hspace=5 />configurations</a></td></tr>                    
     
                    </table>
                </td>
                <td valign=top>
                <iframe height="500" width="99%" scroll=auto frameborder=0 name="contentarea" >
                    
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