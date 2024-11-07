<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    
    if ($password !== $confirm_password) {
        $error_message = "Passwords do not match.";
    } else {
        if (register($username, $password)) {
            $_SESSION['success_message'] = "Registration successful. Please log in.";
            header("Location: login.php");
            exit;
        } else {
            $error_message = "Registration failed. Username may already exist.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - W-Tracker</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="auth-body">
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <i class="bi bi-wallet2"></i>
                <h1>Create Account</h1>
                <p>Start managing your finances today</p>
            </div>

            <?php if ($error_message): ?>
                <div class="alert error"><?php echo $error_message; ?></div>
            <?php endif; ?>

            <form action="register.php" method="post" class="auth-form">
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

                <div class="form-group">
                    <div class="input-icon">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                    </div>
                </div>

                <button type="submit" class="auth-button">Register</button>
            </form>

            <div class="auth-footer">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
