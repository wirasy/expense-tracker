<?php
// Start the session if it hasn't been started already
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="sidebar">
    <h2><i class="bi bi-wallet2"></i> W-Tracker</h2>
    <ul>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="index.php"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a></li>
            <li><a href="add_transaction.php"><i class="bi bi-plus-circle"></i> <span>Add Transaction</span></a></li>
            <li><a href="transaction_history.php"><i class="bi bi-clock-history"></i> <span>Transaction History</span></a></li>
            <li><a href="./auth/logout.php" class="logout-btn"><i class="bi bi-box-arrow-right"></i> <span>Logout</span></a></li>
        <?php else: ?>
            <li><a href="../auth/login.php" class="login-btn"><i class="bi bi-box-arrow-in-right"></i> <span>Login</span></a></li>
            <li><a href="../auth/register.php" class="register-btn"><i class="bi bi-person-plus"></i> <span>Register</span></a></li>
        <?php endif; ?>
    </ul>
</div>