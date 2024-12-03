<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Verify admin access
if (!isset($_SESSION['user_id']) || !is_admin($_SESSION['user_id'])) {
    header('Location: ../auth/login.php');
    exit;
}

$user_id = isset($_GET['id']) ? $_GET['id'] : null;
$message = '';
$type = '';

// Get user data
if ($user_id) {
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $new_password = trim($_POST['new_password']);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;
    
    // Update user data
    if ($new_password) {
        // Update with new password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET username = ?, password = ?, is_admin = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssii", $username, $hashed_password, $is_admin, $user_id);
    } else {
        // Update without changing password
        $sql = "UPDATE users SET username = ?, is_admin = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sii", $username, $is_admin, $user_id);
    }

    if (mysqli_stmt_execute($stmt)) {
        $message = "User updated successfully!";
        $type = "success";
        
        // Refresh user data
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);
    } else {
        $message = "Error updating user: " . mysqli_error($conn);
        $type = "error";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - Admin Panel</title>
    <link rel="icon" type="image/x-icon" href="../asset/w.ico">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container">
        <?php include '../includes/admin_sidebar.php'; ?>
        <div class="content">
            <div class="card-admin">
                <h2><i class="bi bi-person-gear"></i> Edit User</h2>
                
                <?php if ($message): ?>
                    <div class="alert <?php echo $type; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>

                <?php if ($user): ?>
                    <form method="POST" class="form">
                        <div class="form-group-admin">
                            <label for="username">Username</label>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   value="<?php echo htmlspecialchars($user['username']); ?>" 
                                   required>
                        </div>

                        <div class="form-group-admin">
                            <label for="new_password">New Password</label>
                            <input type="password" 
                                   id="new_password" 
                                   name="new_password" 
                                   placeholder="Enter new password">
                        </div>

                        <div class="form-group-admin checkbox-group-admin">
                            <label>
                                <input type="checkbox" 
                                       name="is_admin" 
                                       <?php echo $user['is_admin'] ? 'checked' : ''; ?>>
                                Administrator Access
                            </label>
                        </div>

                        <div class="button-group-admin">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Save Changes
                            </button>
                            <a href="dashboard.php" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Back to Dashboard
                            </a>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert error">User not found.</div>
                    <a href="dashboard.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Dashboard
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
