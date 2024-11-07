<?php
session_start();
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Verify admin access
if (!isset($_SESSION['user_id']) || !is_admin($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$users = get_all_users();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - W-Tracker</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="admin-container">
        <!-- Admin Sidebar -->
        <?php include 'includes/admin_sidebar.php'; ?>

        <!-- Main Content -->
        <div class="admin-content">
            <div class="admin-header">
                <h1>User Management</h1>
                <div class="admin-actions">
                    <button class="add-user-btn" onclick="showAddUserModal()">
                        <i class="bi bi-person-plus"></i> Add New User
                    </button>
                </div>
            </div>

            <!-- User Statistics -->
            <div class="stats-container">
                <div class="stat-card">
                    <i class="bi bi-people"></i>
                    <div class="stat-info">
                        <h3>Total Users</h3>
                        <p><?php echo count($users); ?></p>
                    </div>
                </div>
                <!-- Add more stat cards as needed -->
            </div>

            <!-- User Table -->
            <div class="user-table-container">
                <table class="user-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td>#<?php echo $user['id']; ?></td>
                                <td><?php echo htmlspecialchars($user['username']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                <td><?php echo htmlspecialchars($user['phone_number']); ?></td>
                                <td><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                                <td class="action-buttons">
                                    <button onclick="editUser(<?php echo $user['id']; ?>)" class="edit-btn">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button onclick="deleteUser(<?php echo $user['id']; ?>)" class="delete-btn">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add New User</h2>
            <form id="addUserForm" action="add_user.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="submit-btn">Add User</button>
            </form>
        </div>
    </div>

    <script src="../js/admin.js"></script>
</body>
</html>
