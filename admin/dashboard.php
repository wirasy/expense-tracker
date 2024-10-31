<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

session_start();

// Verify admin access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}

// Get all users
$users = get_all_users();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - W-Tracker</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
        <?php include '../includes/admin_sidebar.php'; ?>
        <div class="content">
            <div class="admin-container">
                <div class="admin-header">
                    <h1>User Management</h1>
                    <button class="add-user-btn" onclick="openAddUserModal()">
                        <i class="bi bi-person-plus"></i> Add New User
                    </button>
                </div>

                <div class="user-stats">
                    <div class="stat-card">
                        <i class="bi bi-people"></i>
                        <div class="stat-info">
                            <h3>Total Users</h3>
                            <p><?php echo count($users); ?></p>
                        </div>
                    </div>
                </div>

                <div class="users-table">
                    <div class="table-header">
                        <input type="text" id="searchUser" placeholder="Search users...">
                        <select id="roleFilter">
                            <option value="all">All Roles</option>
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Created At</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td>#<?php echo $user['id']; ?></td>
                                <td><?php echo $user['username']; ?></td>
                                <td><span class="role-badge <?php echo $user['role']; ?>"><?php echo $user['role']; ?></span></td>
                                <td><?php echo date('d M Y', strtotime($user['created_at'])); ?></td>
                                <td>
                                    <span class="status-badge <?php echo $user['status']; ?>">
                                        <?php echo ucfirst($user['status']); ?>
                                    </span>
                                </td>
                                <td class="actions">
                                    <button onclick="editUser(<?php echo $user['id']; ?>)" class="edit-btn">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button onclick="toggleUserStatus(<?php echo $user['id']; ?>)" class="toggle-btn">
                                        <i class="bi bi-power"></i>
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
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <h2>Add New User</h2>
            <form id="addUserForm">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="button-group">
                    <button type="submit">Add User</button>
                    <button type="button" onclick="closeAddUserModal()">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script src="../js/admin.js"></script>
</body>
</html>