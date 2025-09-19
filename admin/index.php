<?php
session_start();
if ($_POST['MM_Post']=="Post") {
	if ($_POST['username']=="administrator" && $_POST['password']=="priority") {
		$_SESSION['adminLogged']="true";
		header("location: view.php");
		}	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Connect Marketing: Administrative Login</title>
<link href="style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="" target="_top">
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <table width="600" border="0" align="center" cellpadding="15" cellspacing="1" bgcolor="#CCCCCC">
    <tr>
      <td bgcolor="#FFFFFF" style="padding-left: 30px; padding-right:30px;"><table border="0" align="center" cellpadding="5" cellspacing="0">
        <tr>
          <td colspan="2"><img src="../images/logo.gif" width="196" height="117" /></td>
        </tr>
        <tr>
          <td colspan="2" align="center"><strong>ADMINISTRATIVE LOGIN</strong></td>
        </tr>
        <tr>
          <td align="right"><strong>USERNAME:</strong></td>
          <td><input type="text" name="username" id="username" /></td>
        </tr>
        <tr>
          <td align="right"><strong>PASSWORD:</strong></td>
          <td><input type="password" name="password" id="password" /></td>
        </tr>
        <tr>
          <td><input name="MM_Post" type="hidden" id="MM_Post" value="Post" /></td>
          <td><input type="submit" name="button" id="button" value="LOGIN" /></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <p>&nbsp;</p>
</form>
</body>
</html>