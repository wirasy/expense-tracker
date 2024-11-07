<?php
// Start the session if it hasn't been started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="sidebar">
    <h2><i class="bi bi-wallet2"></i> W-Tracker</h2>
    <div class="user-profile">
        <div class="profile-image">
            <i class="bi bi-person-circle"></i>
        </div>
        <div class="user-info">
            <span class="username"><?php echo $_SESSION['username']; ?></span>
        </div>
    </div>
    <ul>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="index.php"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a></li>
            <li><a href="add_transaction.php"><i class="bi bi-plus-circle"></i> <span>Add Transaction</span></a></li>
            <li><a href="transaction_history.php"><i class="bi bi-clock-history"></i> <span>Transaction History</span></a></li>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle">
                    <i class="bi bi-gear"></i> <span>Account Settings</span>
                    <i class="bi bi-chevron-down"></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="change_password.php"><i class="bi bi-lock"></i> <span>Change Password</span></a></li>
                    <li><a href="./auth/logout.php" class="logout-btn"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a></li>
                </ul>
            </li>
        <?php endif; ?>
    </ul>
</div>
