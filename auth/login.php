<?php
session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit;
}

require_once '../includes/db.php';
require_once '../includes/functions.php';

$error_message = "";
$success_message = "";

if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (login($username, $password)) {
        header("Location: ../index.php");
        exit;
    } else {
        $error_message = "Invalid username or password.";
    }
}

// Check for error message from other pages
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - W-Tracker</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <i class="bi bi-wallet2"></i>
                <h1>Welcome Back!</h1>
                <p>Please login to your account</p>
            </div>

            <?php if ($success_message): ?>
                <div class="alert success"><?php echo $success_message; ?></div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="alert error"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form action="login.php" method="post" class="auth-form">
                <div class="form-group">
                    <div class="input-icon">
                        <i class="bi bi-person"></i>
                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-icon">
                        <i class="bi bi-lock"></i>
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                </div>

                <button type="submit" class="auth-button">Login</button>
            </form>

            <div class="auth-footer">
                <p>Don't have an account? <a href="register.php">Register here</a></p>
            </div>
        </div>
    </div>
</body>
</html>

