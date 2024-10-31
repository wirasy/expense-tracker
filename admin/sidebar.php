<div class="sidebar">
    <div class="logo">
        <i class="bi bi-shield-lock"></i>
        <span>Admin Panel</span>
    </div>
    <nav>
        <a href="dashboard.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
            <i class="bi bi-people"></i>
            <span>User Management</span>
        </a>
        <a href="reports.php" class="<?php echo basename($_SERVER['PHP_SELF']) == 'reports.php' ? 'active' : ''; ?>">
            <i class="bi bi-graph-up"></i>
            <span>Reports</span>
        </a>
        <a href="../logout.php">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </a>
    </nav>
</div>