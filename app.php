<?php
session_start();
if (!isset($_SESSION['user'])) header('location:index.php');
$user = (object) $_SESSION['user__info'];
//var_dump($user);
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Vendor styles -->
        <link rel="stylesheet" href="vendors/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css">
        <link rel="stylesheet" href="vendors/bower_components/animate.css/animate.min.css">
        <link rel="stylesheet" href="vendors/bower_components/jquery.scrollbar/jquery.scrollbar.css">
        <link rel="stylesheet" href="vendors/bower_components/select2/dist/css/select2.min.css">
        <link rel="stylesheet" href="vendors/bower_components/dropzone/dist/dropzone.css">
        <link rel="stylesheet" href="vendors/bower_components/flatpickr/dist/flatpickr.min.css" />
        <link rel="stylesheet" href="vendors/bower_components/nouislider/distribute/nouislider.min.css">
        <link rel="stylesheet" href="vendors/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css">
        <link rel="stylesheet" href="vendors/bower_components/trumbowyg/dist/ui/trumbowyg.min.css">
        <link rel="stylesheet" href="vendors/bower_components/rateYo/min/jquery.rateyo.min.css">
        <link rel="stylesheet" href="vendors/bower_components/fullcalendar/dist/fullcalendar.min.css">
        <link rel="stylesheet" href="vendors/bower_components/sweetalert2/dist/sweetalert2.min.css">

        <!-- App styles -->
        <link rel="stylesheet" href="css/app.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body data-sa-theme="<?php echo $user->theme ?>">
        <main class="main">
            <div class="page-loader">
                <div class="page-loader__spinner">
                    <svg viewBox="25 25 50 50">
                        <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
                    </svg>
                </div>
            </div>

            <header class="header">
                <div class="navigation-trigger hidden-xl-up" data-sa-action="aside-open" data-sa-target=".sidebar">
                    <i class="zmdi zmdi-menu"></i>
                </div>

                <div class="logo hidden-sm-down" style="background: url('logos/<?php echo $user->logo ?>') no-repeat center #fff; background-size: contain;">
                    
                </div>

                <form class="search">
                    <div class="search__inner">
                        <input type="text" class="search__text" placeholder="Search for people, files, documents...">
                        <i class="zmdi zmdi-search search__helper" data-sa-action="search-close"></i>
                    </div>
                </form>

                <ul class="top-nav">
                    <li class="hidden-xl-up"><a href="" data-sa-action="search-open"><i class="zmdi zmdi-search"></i></a></li>

                   <!-- <li class="dropdown">
                        <a href="" data-toggle="dropdown" class="top-nav__notify"><i class="zmdi zmdi-email"></i></a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu--block">
                            <div class="dropdown-header">
                                Messages

                                <div class="actions">
                                    <a href="messages.html" class="actions__item zmdi zmdi-plus"></a>
                                </div>
                            </div>

                            <div class="listview listview--hover">
                                <a href="" class="listview__item">
                                    <img src="demo/img/profile-pics/1.jpg" class="listview__img" alt="">

                                    <div class="listview__content">
                                        <div class="listview__heading">
                                            David Belle <small>12:01 PM</small>
                                        </div>
                                        <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                    </div>
                                </a>

                                <a href="" class="listview__item">
                                    <img src="demo/img/profile-pics/2.jpg" class="listview__img" alt="">

                                    <div class="listview__content">
                                        <div class="listview__heading">
                                            Jonathan Morris
                                            <small>02:45 PM</small>
                                        </div>
                                        <p>Nunc quis diam diamurabitur at dolor elementum, dictum turpis vel</p>
                                    </div>
                                </a>

                                <a href="" class="listview__item">
                                    <img src="demo/img/profile-pics/3.jpg" class="listview__img" alt="">

                                    <div class="listview__content">
                                        <div class="listview__heading">
                                            Fredric Mitchell Jr.
                                            <small>08:21 PM</small>
                                        </div>
                                        <p>Phasellus a ante et est ornare accumsan at vel magnauis blandit turpis at augue ultricies</p>
                                    </div>
                                </a>

                                <a href="" class="listview__item">
                                    <img src="demo/img/profile-pics/4.jpg" class="listview__img" alt="">

                                    <div class="listview__content">
                                        <div class="listview__heading">
                                            Glenn Jecobs
                                            <small>08:43 PM</small>
                                        </div>
                                        <p>Ut vitae lacus sem ellentesque maximus, nunc sit amet varius dignissim, dui est consectetur neque</p>
                                    </div>
                                </a>

                                <a href="" class="listview__item">
                                    <img src="demo/img/profile-pics/5.jpg" class="listview__img" alt="">

                                    <div class="listview__content">
                                        <div class="listview__heading">
                                            Bill Phillips
                                            <small>11:32 PM</small>
                                        </div>
                                        <p>Proin laoreet commodo eros id faucibus. Donec ligula quam, imperdiet vel ante placerat</p>
                                    </div>
                                </a>

                                <a href="" class="view-more">View all messages</a>
                            </div>
                        </div>
                    </li>

                    <li class="dropdown top-nav__notifications">
                        <a href="" data-toggle="dropdown" class="top-nav__notify">
                            <i class="zmdi zmdi-notifications"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu--block">
                            <div class="dropdown-header">
                                Notifications

                                <div class="actions">
                                    <a href="" class="actions__item zmdi zmdi-check-all" data-sa-action="notifications-clear"></a>
                                </div>
                            </div>

                            <div class="listview listview--hover">
                                <div class="listview__scroll scrollbar-inner">
                                    <a href="" class="listview__item">
                                        <img src="demo/img/profile-pics/1.jpg" class="listview__img" alt="">

                                        <div class="listview__content">
                                            <div class="listview__heading">David Belle</div>
                                            <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                        </div>
                                    </a>

                                    <a href="" class="listview__item">
                                        <img src="demo/img/profile-pics/2.jpg" class="listview__img" alt="">

                                        <div class="listview__content">
                                            <div class="listview__heading">Jonathan Morris</div>
                                            <p>Nunc quis diam diamurabitur at dolor elementum, dictum turpis vel</p>
                                        </div>
                                    </a>

                                    <a href="" class="listview__item">
                                        <img src="demo/img/profile-pics/3.jpg" class="listview__img" alt="">

                                        <div class="listview__content">
                                            <div class="listview__heading">Fredric Mitchell Jr.</div>
                                            <p>Phasellus a ante et est ornare accumsan at vel magnauis blandit turpis at augue ultricies</p>
                                        </div>
                                    </a>

                                    <a href="" class="listview__item">
                                        <img src="demo/img/profile-pics/4.jpg" class="listview__img" alt="">

                                        <div class="listview__content">
                                            <div class="listview__heading">Glenn Jecobs</div>
                                            <p>Ut vitae lacus sem ellentesque maximus, nunc sit amet varius dignissim, dui est consectetur neque</p>
                                        </div>
                                    </a>

                                    <a href="" class="listview__item">
                                        <img src="demo/img/profile-pics/5.jpg" class="listview__img" alt="">

                                        <div class="listview__content">
                                            <div class="listview__heading">Bill Phillips</div>
                                            <p>Proin laoreet commodo eros id faucibus. Donec ligula quam, imperdiet vel ante placerat</p>
                                        </div>
                                    </a>

                                    <a href="" class="listview__item">
                                        <img src="demo/img/profile-pics/1.jpg" class="listview__img" alt="">

                                        <div class="listview__content">
                                            <div class="listview__heading">David Belle</div>
                                            <p>Cum sociis natoque penatibus et magnis dis parturient montes</p>
                                        </div>
                                    </a>

                                    <a href="" class="listview__item">
                                        <img src="demo/img/profile-pics/2.jpg" class="listview__img" alt="">

                                        <div class="listview__content">
                                            <div class="listview__heading">Jonathan Morris</div>
                                            <p>Nunc quis diam diamurabitur at dolor elementum, dictum turpis vel</p>
                                        </div>
                                    </a>

                                    <a href="" class="listview__item">
                                        <img src="demo/img/profile-pics/3.jpg" class="listview__img" alt="">

                                        <div class="listview__content">
                                            <div class="listview__heading">Fredric Mitchell Jr.</div>
                                            <p>Phasellus a ante et est ornare accumsan at vel magnauis blandit turpis at augue ultricies</p>
                                        </div>
                                    </a>
                                </div>

                                <div class="p-1"></div>
                            </div>
                        </div>
                    </li>

                    <li class="dropdown hidden-xs-down">
                        <a href="" data-toggle="dropdown"><i class="zmdi zmdi-check-circle"></i></a>

                        <div class="dropdown-menu dropdown-menu-right dropdown-menu--block" role="menu">
                            <div class="dropdown-header">Tasks</div>

                            <div class="listview listview--hover">
                                <a href="" class="listview__item">
                                    <div class="listview__content">
                                        <div class="listview__heading">HTML5 Validation Report</div>

                                        <div class="progress mt-1">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="listview__item">
                                    <div class="listview__content">
                                        <div class="listview__heading">Google Chrome Extension</div>

                                        <div class="progress mt-1">
                                            <div class="progress-bar bg-warning" style="width: 43%" aria-valuenow="43" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="listview__item">
                                    <div class="listview__content">
                                        <div class="listview__heading">Social Intranet Projects</div>

                                        <div class="progress mt-1">
                                            <div class="progress-bar bg-success" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="listview__item">
                                    <div class="listview__content">
                                        <div class="listview__heading">Bootstrap Admin Template</div>

                                        <div class="progress mt-1">
                                            <div class="progress-bar bg-info" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="listview__item">
                                    <div class="listview__content">
                                        <div class="listview__heading">Youtube Client App</div>

                                        <div class="progress mt-1">
                                            <div class="progress-bar bg-danger" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="view-more">View all Tasks</a>
                            </div>
                        </div>
                    </li>

                    <li class="dropdown hidden-xs-down">
                        <a href="" data-toggle="dropdown"><i class="zmdi zmdi-apps"></i></a>

                        <div class="dropdown-menu dropdown-menu-right dropdown-menu--block" role="menu">
                            <div class="row app-shortcuts">
                                <a class="col-4 app-shortcuts__item" href="">
                                    <i class="zmdi zmdi-calendar"></i>
                                    <small class="">Calendar</small>
                                </a>
                                <a class="col-4 app-shortcuts__item" href="">
                                    <i class="zmdi zmdi-file-text"></i>
                                    <small class="">Files</small>
                                </a>
                                <a class="col-4 app-shortcuts__item" href="">
                                    <i class="zmdi zmdi-email"></i>
                                    <small class="">Email</small>
                                </a>
                                <a class="col-4 app-shortcuts__item" href="">
                                    <i class="zmdi zmdi-trending-up"></i>
                                    <small class="">Reports</small>
                                </a>
                                <a class="col-4 app-shortcuts__item" href="">
                                    <i class="zmdi zmdi-view-headline"></i>
                                    <small class="">News</small>
                                </a>
                                <a class="col-4 app-shortcuts__item" href="">
                                    <i class="zmdi zmdi-image"></i>
                                    <small class="">Gallery</small>
                                </a>
                            </div>
                        </div>
                    </li> -->


                    <li class="hidden-xs-down">
                        <a href="" class="top-nav__themes" data-sa-action="aside-open" data-sa-target=".themes"><i class="zmdi zmdi-palette"></i></a>
                    </li>
                    <li class="dropdown hidden-xs-down">
                        <a href="" data-toggle="dropdown"><i class="zmdi zmdi-more-vert"></i></a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="" class="dropdown-item" data-sa-action="fullscreen">Fullscreen</a>
                            <a href="logout.php" class="dropdown-item">Logout</a>
                        </div>
                    </li>
                </ul>

                <div class="clock hidden-md-down">
                    <div class="time">
                        <span class="time__hours"></span>
                        <span class="time__min"></span>
                        <span class="time__sec"></span>
                    </div>
                </div>
            </header>

            <aside class="sidebar">
                <div class="scrollbar-inner">

                    <div class="user">
                        <div class="user__info" data-toggle="dropdown">
                            <img class="user__img" src="demo/img/profile-pics/8.jpg" alt="">
                            <div>
                                <div class="user__name"><?php echo $user->fullname ?></div>
                                <div class="user__email"><?php echo $_SESSION['user']; ?></div>
                            </div>
                        </div>

                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" onclick="viewProfile()">View Profile</a>
                            <!--<a class="dropdown-item" href="">Settings</a>-->
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </div>

                    <ul class="navigation">
                        <li class="@@indexactive"><a href=""><i class="zmdi zmdi-home"></i> Home</a></li>
<?php
                        switch ($user->role){
                            case 1:
                            case 3:
                        ?>
                        <li class="navigation__sub @@variantsactive">
                            <a href=""><i class="zmdi zmdi-collection-text"></i> Memos</a>

                            <ul>
                                <li class="@@boxedactive"><a href="#" onclick="create()">Create New</a></li>
                                <li class="@@sidebaractive"><a href="#" onclick="inbox()">Inbox</a></li>
                                <li class="@@sidebaractive"><a href="#" onclick="outbox()">Sent Items</a></li>
                            </ul>
                        </li>
                        <li class="navigation__sub @@chartsactive">
                            <a href=""><i class="zmdi zmdi-chart"></i> <?php  echo $user->companyID!=8?"Appraisal":"Performance Management" ?></a>

                            <ul>
                                <li class="@@flotchartsactive"><a onclick="contract()">My Appraisal Contract</a></li>
                                <li><a onclick="start()">Start/Continue Appraisal</a></li>
                                <li><a onclick="getlines()">Review Line Appraisals</a></li>
                            </ul>
                        </li>
                        <li class="navigation__sub @@tableactive">
                            <a href=""><i class="zmdi zmdi-graduation-cap"></i> Training & Development</a>

                            <ul>
                                <li class="@@normaltableactive"><a href="#" onclick="newTrainingRequest()">Create New Request</a></li>
                                <li><a href="#" onclick="incomingRequests()">Incoming Training Requests</a></li>
                                <li class="@@datatableactive"><a href="#" onclick="trainingRequests()">My Trainings</a></li>
                            </ul>
                        </li>
                        <li class="navigation__sub @@calendaractive">
                            <a href="#"><i class="zmdi zmdi-calendar"></i> Leave Management</a>
                            <ul>
                                <li><a  onclick="leaveCalendar()">My Leave Calendar</a></li>
                                <li><a onclick="leaveRequest()">New Leave Request</a></li>
                                <li><a onclick="lineLeaveRequests()">Line's Leave Requests</a></li>
                            </ul>
                        </li>
                        <li class="navigation__sub @@photogalleryactive">
                        <?php if ($user->companyID==8) { ?>
                            
                            <a href=""><i class="zmdi zmdi-assignment-check"></i> Work Tasks</a>
                            <ul>   
                                <li><a onclick="dailyTasks()">Daily Tasks</a></li>
                                <li><a onclick="weeklyReport()">Weekly Report</a></li>
                                <?php } else {?>
                            <a href=""><i class="zmdi zmdi-assignment-check"></i> Weekly Journal</a>
                            <ul>    
                                <li><a onclick="getMyPerformance()">My Performance Tracker</a></li>
                                <li><a onclick="getLine()">Evaluate Line Performance</a></li>
                                <?php } ?>
                            </ul>
                        </li>
                        <li class="navigation__sub @@formactive">
                           <a href=""><i class="zmdi zmdi-receipt"></i>Payroll</a>
                            <ul>
                               <?php if ($user->companyID!=8) { ?>
                                <li><a href="#" onclick="payslip(null,true)">My Latest Payslip</a></li>
                                <li><a href="#" onclick="archives()">Archive</a></li>
                               <?php } else { ?>
                               <li><a href="#" onclick="makeSlipRequest()">Request Payslip</a></li>
                               <?php } ?>
                            </ul>
                        </li>
                        <li class="navigation__sub @@uiactive">
                           <?php //if ($user->companyID!=8){ ?>
                            <a href=""><i class="zmdi zmdi-labels"></i> Support</a>

                            <ul>
                                <li class="@@colorsactive"><a href="#" onclick="startInventoryRequest()">New Inventory Request</a></li>
                                <li class="@@colorsactive"><a href="#" onclick="startNewBrief()">New Project Brief</a></li>
                                <!--include briefing templates
                                <li class="@@colorsactive"><a href="#" onclick="startBrief('events')">New Events/Special Projects Brief</a></li>
                                <li class="@@colorsactive"><a href="#" onclick="startBrief('creative')">Creative Projects Brief</a></li>
                                <li class="@@colorsactive"><a href="#" onclick="startBrief('research')">Research & Strategy Brief</a></li>-->
                                <li class="@@colorsactive"><a href="#" onclick="getSupportRequests()">My Support Requests</a></li>
                                <li><a href="#" onclick="showRateCard()">View Rate Card</a></li>
                            </ul>
                            <?php //} else { ?>
                            <a href=""><i class="zmdi zmdi-time"></i> Attendance Management</a>

                            <ul>
                                <li class="@@colorsactive"><a href="#" onclick="clock('In')">Clock In</a></li>
                                <li class="@@colorsactive"><a href="#" onclick="clock('Out')">Clock Out</a></li>
                            </ul>
                            <?php //} ?>
                        </li>
                        <?php
                            break;
                            case 2:                                
                        ?>
                        <li class="navigation__sub">
                            <a href="" onclick="showRateCard()"><i class="zmdi zmdi-assignment-o"></i> Rate Card</a>
                            <a href=""><i class="zmdi zmdi-collection-text"></i> Project Briefs</a>
                            <ul>
                                <li><a href="#" onclick="getbriefs()">Quotation Requests</a></li>
                                <li><a>History</a></li>
                            </ul>
                            <a href><i class="zmdi zmdi-assignment-check"></i>Evaluate Procurement Team</a>
                        </li>
                               <?php
                                
                            break;
                        }
                        ?>                        
                    </ul>
                </div>
            </aside>

            <div class="themes">
                <div class="scrollbar-inner">
                    <a href="" class="themes__item active" data-sa-value="1"><img src="img/bg/1.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="2"><img src="img/bg/2.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="3"><img src="img/bg/3.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="4"><img src="img/bg/4.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="5"><img src="img/bg/5.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="6"><img src="img/bg/6.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="7"><img src="img/bg/7.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="8"><img src="img/bg/8.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="9"><img src="img/bg/9.jpg" alt=""></a>
                    <a href="" class="themes__item" data-sa-value="10"><img src="img/bg/10.jpg" alt=""></a>
                </div>
            </div>

            <section class="content">
                <div class="content__inner">
                    <header class="content__title">
                        <h1 id="card-header"></h1>
                    </header>

                    <div class="card">

                        <div id="view" class="card-body">
                         <?php if ($user->role==1 || $user->role==3) { ?>
                          <div class="row">
                           <div class="col-md-4 col-sm-6">
                              <div class="container">
                               <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Recent Posts</h4>
                                        <h6 class="card-subtitle">Requests and Returns will show here</h6>
                                    </div>

                                    <div id="notificationsCard" class="listview listview--hover">
                                       {{each object}}
                                        <a class="listview__item">
                                            <img src="demo/img/profile-pics/1.jpg" class="listview__img" alt="">

                                            <div class="listview__content">
                                                <div class="listview__heading">${SentBy} on ${postdate}</div>
                                                <p>${description}</p>
                                            </div>
                                        </a>
                                        {{/each}}
                                        <!--<a href="" class="view-more">View All Posts</a>-->
                                    </div>
                                    <p>&nbsp;</p>
                                    <?php //if ($user->companyID==8) { ?>
                                    <div class="card">
                                    <div class="card-body">
                                        <div class="card-title"><h5>Work Attendance</h5></div>
                                        <a class="btn btn-block btn-success" onclick="clock('in')">Clock In</a>
                                        <a class="btn btn-block btn-danger" onclick="clock('out')">Clock Out</a>
                                        <input type="hidden" id='more_info' name="more_info" />

                                    </div>
                                    </div>
                                    <?php //} ?>
                            </div>
                              </div>
                           </div>
                           <div class="col-md-4 col-sm-6">
                                <div class="container">
                                 <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Weekly Journal</h4>
                                    </div>
                                   <div class="accordion" role="tablist">
                                            <div class="card">
                                                <div class="card-header" role="tab" id="headingOne">
                                                    <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" class="">
                                                        What you need to know
                                                    </a>
                                                </div>

                                                <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion" style="">
                                                    <div class="card-body">
                                                        <ul>
              <li>Employees are expected to fill in the Daily Task Time sheet and submit each day before 5:30pm.<br>&nbsp;</li>
              <li>Line Managers are required to brief (via email or verbal) team members on additonal task (if any).<br>&nbsp;</li>
              <li>Start &amp; End time for completed task for must be inputed.<br>&nbsp;</li>
              <li>Additonal tasks from other Unit(s) should be inputed in the sheets.<br>&nbsp;</li>
              <li>Meeting: Meeting contact report must be sent not later than 24hours, or as stipulated by Client/LM<br>&nbsp;</li>
              <li>Timesheets should be ractified by LM on a daily basis, by commenting on the allocated column. In the absence of Line Manager, sheet should be signed the next morning. During leave, this responsibility should be delegated.<br>&nbsp;</li>
              <li>Adequate check and remark by Line Manager will carry 10% appraisal score on Internal Process.<br>&nbsp;</li>
              <li>Penalty: Failure to fill the form will attract a fine of =N=500 daily. <br>&nbsp;</li>
            </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" role="tab" id="headingTwo">
                                                    <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                        Task Progress Tracker
                                                    </a>
                                                </div>
                                                <div id="collapseTwo" class="collapse show" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion" style="">
                                                    <div class="card-body">
                                                        <div id="dTasks" class="listview">
                                                           <strong>${object==null?'No tasks entered':''}</strong>
                                                           {{each object}}
                                                            <a href="#" class="listview__item" title="${status!=null?status.comments:''}">
                                                                <div class="listview__content">
                                                                    <div class="listview__heading">${toDo}</div>

                                                                    <div class="progress mt-2">
                                                                        <div class="progress-bar ${status!=null?status.class:''}" style="width: ${status!=null?status.percentage:''}%" aria-valuenow="${status!=null?status.percentage:''}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                            {{/each}}

                                                                <a href="" class="view-more">View All Tasks</a>
                                                            </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                </div>
                                </div>
                          </div>
                           <div class="col-md-4 col-sm-6">
                              <div class="container">
                                   <div class="card">
                                       <div class="card-body">
                                           <a href="handbook/<?php echo $user->handbook; ?>" class="btn btn-dark btn-block">Staff Handbook</a>
                                       </div>
                                   </div>
                                   <div class="card">
                                       <div class="card-body">
                                           <div id="leaveCounter">
                                              <center>
                                               <p><span class="h2">${daysLeft}</span>&nbsp;days<br />to next leave</p>
                                               <h2>${day}</h2>
                                               </center>
                                           </div>
                                       </div>
                                   </div>
                               </div>
                           </div>
                            </div>
                          
                        <?php if ($user->agreedToHandbook!=1){ ?>
                        <div class="modal fade" id="handbookModal" data-keyboard="false">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header"><h5><?php echo $user->companyName;  ?> Staff Handbook</h5></div>
                                    <div class="modal-body">
                                        <embed src="handbook/<?php echo $user->handbook; ?>#toolbar=0&navpanes=0&scrollbar=0" type="application/pdf" width="100%" height="600px" />
                                    </div>

                                    <div class="modal-footer">
                                        <p>Can't view document, <a href="handbook/<?php echo $user->handbook; ?>" target="_blank" >click here</a> view downloadable copy.</p>
                                        <p><button class="btn btn-light" onclick="readHandbook()" >Yes, I read the Handbook</button></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?> 
                        <?php } else { ?>
                        <h6>ASSESSMENT METRICS</h6>
                        <P>&nbsp;</P>
                        <table border="0" class="table table-striped table-bordered" cellspacing="0" cellpadding="4">
                                          <tr>
                                            <td nowrap="nowrap" rowspan="2"><p><strong>Metric</strong></p></td>
                                            <td rowspan="2"><p align="center"><strong>Metric   Weight</strong></p></td>
                                            <td rowspan="2"><p align="center"><strong>Weighting   per sub KPI</strong></p></td>
                                            <td nowrap="nowrap" rowspan="2"><p><strong>KPI </strong></p></td>
                                            <td rowspan="2"><p><strong>KPI Measurement</strong></p></td>
                                          </tr>
                                          <tr> </tr>
                                          <tr>
                                            <td><p>Time</p></td>
                                            <td><p align="center">20%</p></td>
                                            <td><p align="center">20%</p></td>
                                            <td><p>Setup Timeliness</p></td>
                                            <td><p>Time at which the vendor got to the venue for   setup</p></td>
                                          </tr>
                                          <tr>
                                            <td><p>Interpersonal Relationship</p></td>
                                            <td><p align="center">10%</p></td>
                                            <td><p align="center">10%</p></td>
                                            <td><p> Mutual   respect, Team spirit, Fostering relationship </p></td>
                                            <td><p>Has a good understanding of our business   objectives and core values</p></td>
                                          </tr>
                                          <tr>
                                            <td rowspan="2"><p>Delivery &amp; Support </p></td>
                                            <td nowrap="nowrap" rowspan="2"><p align="center">20%</p></td>
                                            <td nowrap="nowrap"><p align="center">10%</p></td>
                                            <td><p>Communication</p></td>
                                            <td><p>Degree to which supplier provides timely   information to influence outcome of CMS events positively</p></td>
                                          </tr>
                                          <tr>
                                            <td nowrap="nowrap"><p align="center">10%</p></td>
                                            <td><p>Problem Resolution</p></td>
                                            <td><p>Suppliers has the ability to cope, respond to or   handle late approvals, changes, cancellations and inform you of crucial  deadlines and developments in good time.</p></td>
                                          </tr>
                                          <tr>
                                            <td nowrap="nowrap" rowspan="2"><p>Quality</p></td>
                                            <td nowrap="nowrap" rowspan="2"><p align="center">20%</p></td>
                                            <td nowrap="nowrap"><p align="center">10%</p></td>
                                            <td rowspan="2"><p>Technical Expertise</p></td>
                                            <td><p>Events management    of a consistently high standard in terms of effect on expected results</p></td>
                                          </tr>
                                          <tr>
                                            <td nowrap="nowrap"><p align="center">10%</p></td>
                                            <td><p>Supplier displays leading-edge technical   expertise and robust understanding of world class events production and   activations</p></td>
                                          </tr>
                                          <tr>
                                            <td rowspan="2"><p>Professionalism</p></td>
                                            <td nowrap="nowrap" rowspan="2"><p align="center">30%</p></td>
                                            <td nowrap="nowrap"><p align="center">5%</p></td>
                                            <td rowspan="2"><p>Provision of Innovative Solutions</p></td>
                                            <td><p>Is proactive and takes constructive initiatives</p></td>
                                          </tr>
                                          <tr>
                                            <td nowrap="nowrap"><p align="center">5%</p></td>
                                            <td><p>Degree to which supplier proactively provides   valuable, innovative, and on-target events and activations  solutions </p></td>
                                          </tr>
                                        </table>
                                        <p>&nbsp;</p>
                                        <p>Supplier should take note that in the event of default on agreed deliverables, the below clause will be applicable to them.</p>
                                        <ul>
                                          <li>1st Default –  Supplier will be surcharged at a certain percentage to be deducted from invoice</li>
                                          <li>2nd Default – Supplier will be degraded (will not be on our priority list) and surcharged</li>
                                          <li>3rd Default – Supplier will be delisted</li>
                                        </ul>
                        <?php } ?>
                        </div>
                        <div class="modal fade" id="loginModal" data-keyboard="false">
                            <div class="modal-dialog modal-md">
                                <div class="modal-content">
                                    <div class="modal-header"><h5>User Login</h5></div>
                                    <div class="modal-body">
                                        <div id="login-msg"></div>
                                        <form id="loginForm" method="post">
                                            <div class="form-group">
                                                <input name="username" type="text" class="form-control" placeholder="Email Address">
                                            </div>
                                            <div class="form-group">
                                                <input name="password" type="password" class="form-control" placeholder="Password">
                                            </div>
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="#" onclick="login();" class="btn btn-light btn-block btn--icon-text">Login <i class="zmdi zmdi-long-arrow-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <footer class="footer hidden-xs-down">
                        <p>Republicom - HRIS . All rights reserved.</p>

                        <ul class="nav footer__nav">
                            <a class="nav-link" href="#">Engineered by MediaTrix&copy;2019</a>
                        </ul>
                    </footer>
                </div>
            </section>
            
                    <div id="template"></div>
        </main>

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
        <script src="vendors/bower_components/jquery/dist/jquery.min.js"></script>
        <script src="vendors/bower_components/popper.js/dist/umd/popper.min.js"></script>
        <script src="vendors/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="vendors/bower_components/jquery.scrollbar/jquery.scrollbar.min.js"></script>
        <script src="vendors/bower_components/jquery-scrollLock/jquery-scrollLock.min.js"></script>

       <!-- Forms -->
        <script src="vendors/bower_components/jquery-mask-plugin/dist/jquery.mask.min.js"></script>
        <script src="vendors/bower_components/select2/dist/js/select2.full.min.js"></script>
        <script src="vendors/bower_components/dropzone/dist/min/dropzone.min.js"></script>
        <script src="vendors/bower_components/moment/min/moment.min.js"></script>
        <script src="vendors/bower_components/flatpickr/dist/flatpickr.min.js"></script>
        <script src="vendors/bower_components/nouislider/distribute/nouislider.min.js"></script>
        <script src="vendors/bower_components/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
        <script src="vendors/bower_components/trumbowyg/dist/trumbowyg.min.js"></script>
        <script src="vendors/bower_components/rateYo/min/jquery.rateyo.min.js"></script>
        <script src="vendors/bower_components/jquery-text-counter/textcounter.min.js"></script>
        <script src="vendors/bower_components/autosize/dist/autosize.min.js"></script>
        <script src="vendors/bower_components/jquery-template/jquery.tmpl.min.js"></script>
        <script src="vendors/bower_components/fullcalendar/dist/fullcalendar.min.js"></script>
        <script src="vendors/bower_components/sweetalert2/dist/sweetalert2.min.js"></script>
        
        <!-- Data Table -->
        <script src="vendors/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
        <script src="vendors/bower_components/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
        <script src="vendors/bower_components/datatables.net-buttons/js/buttons.print.min.js"></script>
        <script src="vendors/bower_components/jszip/dist/jszip.min.js"></script>
        <script src="vendors/bower_components/datatables.net-buttons/js/buttons.html5.min.js"></script>
        
        <!-- Custom -->
        <script src="js/script.js"></script>
        
        <!-- Views -->
        <script src="views/memo.js"></script>
        <script src="views/payroll.js"></script>
        <script src="views/training.js"></script>
        <script src="views/journal.js"></script>
        <script src="views/leave.js"></script>
        <script src="views/appraisal.js"></script>
        <script src="views/performance.js"></script>
        <script src="views/support.js"></script>
        <script src="views/supplier.js"></script>
        <script src="views/user.js"></script>
        <?php if ($user->role==1 || $user->role==3) { ?>
        <script src="views/dashboard.js"></script>
        <?php } ?>
        <!-- App functions and actions -->
        <script src="js/app.min.js"></script>
         <?php if ($user->agreedToHandbook!=1){ ?>
        <script>
            $('#handbookModal').modal('show');
        </script>
        <?php } ?>
        <?php 
            //if samsung login
            if ($user->companyID==8) { 
        ?>    
        <script src="js/client.min.js"></script>
        <script src="js/location.js"></script>
        <?php
            }   
        ?>
    </body>
</html>