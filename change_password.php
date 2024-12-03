<?php
session_start();
require_once 'includes/db.php';
require_once 'includes/functions.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: auth/login.php');
    exit;
}

$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    if ($new_password !== $confirm_password) {
        $error_message = "New passwords do not match.";
    } else if (change_user_password($_SESSION['user_id'], $current_password, $new_password)) {
        $success_message = "Password changed successfully!";
    } else {
        $error_message = "Current password is incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - We Tracker</title>
    <link rel="icon" type="image/x-icon" href="asset/w.ico">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container">
        <?php include 'includes/sidebar.php'; ?>
        <div class="content">
            <div class="password-container">
                <div class="password-card">
                    <div class="password-header">
                        <i class="bi bi-shield-lock"></i>
                        <h1>Change Password</h1>
                    </div>

                    <?php if ($success_message): ?>
                        <div class="alert success"><?php echo $success_message; ?></div>
                    <?php endif; ?>

                    <?php if ($error_message): ?>
                        <div class="alert error"><?php echo $error_message; ?></div>
                    <?php endif; ?>

                    <form action="change_password.php" method="post" class="password-form">
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <div class="input-icon">
                                <i class="bi bi-lock"></i>
                                <input type="password" id="current_password" name="current_password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="new_password">New Password</label>
                            <div class="input-icon">
                                <i class="bi bi-lock-fill"></i>
                                <input type="password" id="new_password" name="new_password" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="confirm_password">Confirm New Password</label>
                            <div class="input-icon">
                                <i class="bi bi-lock-fill"></i>
                                <input type="password" id="confirm_password" name="confirm_password" required>
                            </div>
                        </div>

                        <button type="submit" class="change-btn">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
