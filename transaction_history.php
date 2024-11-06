<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "You must be logged in to access this page.";
    header('Location: login.php');
    exit;
}
$expenses = get_expenses();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History - W-Tracker</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="container">
        <?php include 'includes/sidebar.php'; ?>
        <div class="content">
            <div class="history-container">
                <div class="history-header">
                    <h1>Transaction History</h1>
                </div>
                <div class="transaction-list">
                    <?php foreach ($expenses as $expense): ?>
                    <div class="transaction-card <?php echo $expense['type']; ?>">
                    <div class="transaction-icon">
                    <i class="bi <?php echo $expense['type'] == 'income' ? 'bi-arrow-up-circle-fill' : 'bi-arrow-down-circle-fill'; ?>"></i>
                    </div>
                    <div class="transaction-details">
                    <h3><?php echo htmlspecialchars($expense['description']); ?></h3>
                    <span class="category"><?php echo htmlspecialchars($expense['category']); ?></span>
                    <span class="date"><?php echo date('d M Y', strtotime($expense['date'])); ?></span>
                    </div>
                    <div class="transaction-amount <?php echo $expense['type']; ?>">
                    <?php echo $expense['type'] == 'income' ? '+' : '-'; ?> Rp. <?php echo number_format($expense['amount'], 3); ?>
                    </div>
                    <div class="transaction-actions">
                    <a href="edit_transaction.php?id=<?php echo $expense['id']; ?>" class="edit-btn" title="Edit">
                    <i class="bi bi-pencil-fill"></i>
                    </a>
                    <a href="delete_transaction.php?id=<?php echo $expense['id']; ?>" class="delete-btn" title="Delete" 
                    onclick="return confirm('Are you sure you want to delete this transaction?')">
                    <i class="bi bi-trash-fill"></i>
                    </a>
                    </div>
                    </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="js/script.js"></script>
</body>
</html>

