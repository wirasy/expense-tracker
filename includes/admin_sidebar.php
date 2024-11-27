<div class="sidebar">
    <h2><i class="bi bi-shield-lock"></i> Admin Panel</h2>
    <div class="user-profile">
        <div class="profile-image">
            <i class="bi bi-person-circle"></i>
        </div>
        <div class="user-info">
            <span class="username"><?php echo $_SESSION['username']; ?></span>
            <span class="role">Administrator</span>
        </div>
    </div>
    <ul>
        <li><a href="dashboard.php"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a></li>
        <li><a href="../auth/logout.php"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a></li>
    </ul>
</div>
