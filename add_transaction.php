<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "You must be logged in to access this page.";
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $date = $_POST['date'];
    $type = $_POST['type'];

    if (add_transaction($amount, $description, $category, $date, $type)) {
        $success_message = "Transaction added successfully.";
    } else {
        $error_message = "Error adding transaction.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Transaction - W-Tracker</title>
    <link rel="icon" type="image/x-icon" href="asset/w.ico">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<div class="container">
    <?php include 'includes/sidebar.php'; ?>
    <div class="content">
        <div class="form-container">
            <div class="form-card">
                <h1>Add Transaction</h1>
                <?php if (isset($success_message)): ?>
                    <p class="success"><?php echo $success_message; ?></p>
                <?php endif; ?>
                <?php if (isset($error_message)): ?>
                    <p class="error"><?php echo $error_message; ?></p>
                <?php endif; ?>
                
                <form action="add_transaction.php" method="post" class="transaction-form">
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" id="amount" name="amount" placeholder="Enter amount" required step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" id="description" name="description" placeholder="Enter description" required autocomplete="off">
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="Food">Food</option>
                            <option value="Transportation">Transportation</option>
                            <option value="Entertainment">Entertainment</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" required>
                    </div>

                    <div class="form-group">
                        <label for="type">Type</label>
                        <select id="type" name="type" required>
                            <option value="expense">Expense</option>
                            <option value="income">Income</option>
                        </select>
                    </div>

                    <button type="submit" class="submit-btn">Add Transaction</button>
                </form>
            </div>
        </div>
    </div>
</div>

    <script src="js/script.js"></script>
</body>
</html>
