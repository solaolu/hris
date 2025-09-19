<?php
// dashboard.php

session_start();
if (!isset($_SESSION['user__info'])) {
    header('Location: ../index.php');
    exit();
}

$user = (object) $_SESSION['user__info'];
$accessLevel = $user->accessLevel;

// Define a structured array for navigation links based on access levels
$navLinks = [
    // HR Module
    1 => [
        'HR MODULE',
        ['label' => 'Create New User', 'href' => 'createuser.php'],
        ['label' => 'Employee List', 'href' => 'userMgt.php'],
        ['label' => 'Job Positions', 'href' => 'createjobs.php'],
        ['label' => 'Send Letter', 'href' => 'sendletter.php'],
        ['label' => 'Appraisal Periods', 'href' => 'createappraisals.php'],
        ['label' => 'Scorecard Management', 'href' => 'listScorecards.php'],
        ['label' => 'General Appraisal Questions', 'href' => 'listGPE.php'],
        ['label' => 'Set Weekly Task(s)', 'href' => 'settasks.php'],
        ['label' => 'Upload Annual Leave Schedule', 'href' => 'uploadleaveschedule.php?m=individual'],
        ['label' => 'View Annual Leave Schedule (Individual)', 'href' => 'leaveschedule.php?m=individual'],
        ['label' => 'View Annual Leave Schedule (Department)', 'href' => 'leaveschedule.php?m=department'],
        ['label' => 'Leave Requests', 'href' => 'listleaverequests.php'],
        ['label' => 'Reset Annual Schedule', 'href' => 'reset.php'],
        ['label' => 'Manage Salaries', 'href' => 'payslip.php'],
        ['label' => 'Internal Training Attendance', 'href' => 'attendance.php'],
        ['label' => 'Training Requests', 'href' => 'listtrainingrequests.php'],
    ],
    // Finance Module
    2 => [
        'FINANCE MODULE',
        ['label' => 'Download Latest Payables', 'href' => 'payables.php'],
    ],
    // Procurement Module
    3 => [
        'PROCUREMENT MODULE',
        ['label' => 'Supplier Applications', 'href' => 'procurementapplications.php'],
        ['label' => 'Suppliers List', 'href' => 'supplierslist.php'],
        ['label' => 'Supplier Briefs', 'href' => 'supplierbrief.php'],
        ['label' => 'Job Completion Reports', 'href' => 'jobcompletion.php'],
        ['label' => 'Project Evaluation Report', 'href' => 'supplierappraisallist.php'],
    ],
    // Inventory Module
    4 => [
        'INVENTORY MODULE',
        ['label' => 'Inventory Requests', 'href' => 'inventoryrequests.php'],
        ['label' => 'Inventory Items', 'href' => 'listinventoryitems.php'],
    ],
    // Sales Force Module
    5 => [
        'SALES FORCE MODULE',
        ['label' => 'Create New User', 'href' => 'createuser.php'],
        ['label' => 'Employee List', 'href' => 'userMgt.php'],
        ['label' => 'Job Positions', 'href' => 'createjobs.php'],
        ['label' => 'Appraisal Periods', 'href' => 'createappraisals.php'],
        ['label' => 'Scorecard Management', 'href' => 'listScorecards.php'],
        ['label' => 'General Appraisal Questions', 'href' => 'listGPE.php'],
        ['label' => 'Upload Annual Leave Schedule', 'href' => 'uploadleaveschedule.php?m=individual'],
        ['label' => 'View Annual Leave Schedule (Individual)', 'href' => 'leaveschedule.php?m=individual'],
        ['label' => 'View Annual Leave Schedule (Department)', 'href' => 'leaveschedule.php?m=department'],
        ['label' => 'Leave Requests', 'href' => 'listleaverequests.php'],
        ['label' => 'Reset Annual Schedule', 'href' => 'reset.php'],
        ['label' => 'Payslip Requests', 'href' => 'listPaysliprequests.php'],
        ['label' => 'Training Requests', 'href' => 'listtrainingrequests.php'],
        ['label' => 'Vacancies', 'href' => 'listvacancies.php'],
    ],
    // Super Admin
    -1 => [
        'SUPER ADMIN',
        ['label' => 'Employee Management', 'href' => 'start.php?p=1'],
    ],
];

if (isset($navLinks[$accessLevel])) {
    $currentModule = $navLinks[$accessLevel][0];
    $navItems = array_slice($navLinks[$accessLevel], 1);
} else {
    // Handle invalid access level, e.g., redirect to an error page
    $currentModule = 'Module Not Found';
    $navItems = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Connect Marketing Online: HRIS Administrative Panel</title>
    <link href="../jquery.autocomplete.css" rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />
    <script src="../jquery.min.js"></script>
    <script src="../jquery.autocomplete.min.js"></script>
</head>
<body>
    <header class="main-header">
        <img src="../logos/republicom.png" alt="Republicom Logo" class="logo" />
        <h1>HRIS ADMINISTRATIVE PANEL</h1>
        <a href="logout.php" class="logout-button">Logout</a>
    </header>
    <div class="container">
        <aside class="sidebar">
            <div class="search-box">
                <input type="text" id="search" class="inputbox" placeholder="Employee Name" />
                <button id="search-button" class="button">Search</button>
            </div>
            <nav class="main-nav">
                <h3><?= htmlspecialchars($currentModule) ?></h3>
                <ul>
                    <?php foreach ($navItems as $item): ?>
                        <li><a href="<?= htmlspecialchars($item['href']) ?>"><?= htmlspecialchars($item['label']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </nav>
        </aside>
        <main class="content-area">
            <p>Welcome to the HRIS Admin Panel. Select an option from the menu to get started.</p>
        </main>
    </div>
    
    <script src="dashboard.js"></script>
</body>
</html>