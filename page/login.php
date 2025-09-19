<?php
require_once("../models/user.php");

$m=isset($_GET['m'])?$_GET['m']:'';
if (isset($_POST['username']) && isset($_POST['password'])){
    $User = new User();
    $user=(Object) ['username'=>$_POST['username'], 'password'=>$_POST['password'], 'more_info'=>$_POST['more_info']];
    
    $User->login($user);
    $result = $User->getResult();
    if ($result->isSuccessful){
        $user = (object) $result->object;
        if ($user->role==1||$user->role==3){
            if ($user->isPasswordChanged==0){
                $msg = "Password change required!";
            } else {
                //echo "Welcome, you will now be redirected to: $result->url";
               if ($user->role==1) header("location:../$result->url");
                $msg = "You have administrative privileges. Please select the user mode you want to use to operate the application";
            }
        } else {
            header("location:../$result->url");
        }
    } else {
        header("location:../index.php?m=$m&login=failed");
    }
    
   /* if isset($_POST['rememberMe']) {
        
    }*/
    
} else {
    header('location:../index.php?m='.$m);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Vendor styles -->
        <link rel="stylesheet" href="../vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
        <link rel="stylesheet" href="../vendors/bower_components/animate.css/animate.min.css">

        <!-- App styles -->
        <link rel="stylesheet" href="../css/app.min.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body data-sa-theme="1">
        <div class="login">

            <!-- Login -->
            <div class="login__block active" id="l-login">
               <div class="logo-box">
                   <img src="../logos/republicom.png" width="200" />
               </div>
                <div class="login__block__header">
                  <?php echo $msg; ?>
                </div>

                <div class="login__block__body">
                  <?php if ($user->role<=2) { ?>
                   <form id="passwordChangeForm" method="post" action="page/change_password.php">
                    <div class="form-group">
                        <input name="oldpassword" type="password" class="form-control text-center" placeholder="Current Password">
                    </div>
                    <div class="form-group">
                        <input name="newpassword" type="password" class="form-control text-center" placeholder="New Password">
                    </div>
                    <div class="form-group">
                        <input name="cnewpassword" type="password" class="form-control text-center" placeholder="Confirm Password">
                    </div>
                    <input type="hidden" name="more_info" id="more_info" />
                    <a href="#" onclick="changePassword()" class="btn btn-light btn-block btn--icon-text">Change Password&nbsp;<i class="zmdi zmdi-long-arrow-right"></i></a>
                   </form>
                  <?php } elseif ($user->role==3){ ?>
                          <div class="row">
                              <a class="col-md-6" href="../app.php"><h1><i class="zmdi zmdi-account-circle zmdi-hc-fw"></i></h1>Regular</a>
                              <a class="col-md-6" href="../admin/dashboard.php"><h1><i class="zmdi zmdi-globe-lock zmdi-hc-fw"></i></h1>Admin</a>
                          </div>  
                  <?php } ?>
                </div>
            </div>

        </div>
        
        
                <footer class="footer hidden-xs-down">
                    <p>Republicom - HRIS . All rights reserved.</p>

                    <ul class="nav footer__nav">
                        <a class="nav-link" href="#">Engineered by MediaTrix&copy;2019</a>
                    </ul>
                </footer>

        <!-- Older IE warning message -->
            <!--[if IE]>
                <div class="ie-warning">
                    <h1>Warning!!</h1>
                    <p>You are using an outdated version of Internet Explorer, please upgrade to any of the following web browsers to access this website.</p>

                    <div class="ie-warning__downloads">
                        <a href="http://www.google.com/chrome">
                            <img src="img/browsers/chrome.png" alt="">
                        </a>

                        <a href="https://www.mozilla.org/en-US/firefox/new">
                            <img src="img/browsers/firefox.png" alt="">
                        </a>

                        <a href="http://www.opera.com">
                            <img src="img/browsers/opera.png" alt="">
                        </a>

                        <a href="https://support.apple.com/downloads/safari">
                            <img src="img/browsers/safari.png" alt="">
                        </a>

                        <a href="https://www.microsoft.com/en-us/windows/microsoft-edge">
                            <img src="img/browsers/edge.png" alt="">
                        </a>

                        <a href="http://windows.microsoft.com/en-us/internet-explorer/download-ie">
                            <img src="img/browsers/ie.png" alt="">
                        </a>
                    </div>
                    <p>Sorry for the inconvenience!</p>
                </div>
            <![endif]-->

        <!-- Javascript -->
        <!-- Vendors -->
        <script src="../vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="../vendors/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script src="../vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

        <!-- App functions and actions -->
        <script src="../js/app.min.js"></script>
        <script src="../js/script.js"></script>
        <Script src="../views/user.js"></Script>
        <script src="../js/client.min.js"></script>
        <script src="../js/location.js"></script>
    </body>
</html>