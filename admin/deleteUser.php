<?php
declare(strict_types=1);
session_start();

require_once('checkAdmin.php');
require_once('../Connections/cn.php');

// CSRF token generation and verification
function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
}
function verifyCsrfToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}
generateCsrfToken();

$errors = [];
$success = false;

// Only handle POST requests for deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        $errors[] = 'Invalid CSRF token.';
    }

    // Validate user input
    $user = filter_input(INPUT_POST, 'un', FILTER_VALIDATE_EMAIL);
    if (!$user) {
        $errors[] = 'Invalid user identifier.';
    }

    if (empty($errors)) {
        // Use prepared statement for each table
        $tables = [
            "staff_tbl",
            "appraisal360_tbl",
            "kpi_details_tbl",
            "kpi_summary_tbl",
            "my360_tbl"
        ];
        $conn = $cn;
        foreach ($tables as $table) {
            // In some tables, the identifier is 'email', in others it's 'owner'
            $column = in_array($table, ["staff_tbl"]) ? "email" : "owner";
            $sql = "UPDATE $table SET isDeleted=1 WHERE $column = ?";
            $stmt = $conn->prepare($sql);
            if ($stmt) {
                $stmt->bind_param("s", $user);
                $stmt->execute();
                $stmt->close();
            }
        }
        $success = true;
    }
}

// If GET, show confirmation form
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user = filter_input(INPUT_GET, 'un', FILTER_VALIDATE_EMAIL);
    if (!$user) {
        $errors[] = 'Invalid user identifier.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete User | HRIS Admin</title>
    <link href="style.css" rel="stylesheet" type="text/css" />
</head>
<body>
<div class="container">
    <h2>Delete User</h2>
    <?php if ($success): ?>
        <div class="success">User deleted successfully. <a href="userMgt.php">Back to User Management</a></div>
    <?php elseif (!empty($errors)): ?>
        <div class="error">
            <ul><?php foreach ($errors as $error) echo '<li>' . htmlspecialchars($error) . '</li>'; ?></ul>
        </div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($user)): ?>
        <form method="post" action="deleteUser.php" onsubmit="return confirm('Are you sure you want to permanently delete this user? This action cannot be undone.');">
            <p>Are you sure you want to delete the user <strong><?= htmlspecialchars($user) ?></strong>?</p>
            <input type="hidden" name="un" value="<?= htmlspecialchars($user) ?>">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <button type="submit" class="button" style="background:#e74c3c;">Delete User</button>
            <a href="userMgt.php" class="button">Cancel</a>
        </form>
    <?php endif; ?>
</div>
</body>
</html>
