<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

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
    <title>Add Transaction - Expense Tracker</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
        <?php include 'includes/sidebar.php'; ?>
        <div class="content">
            <h1>Add Transaction</h1>
            <?php if (isset($success_message)): ?>
                <p class="success"><?php echo $success_message; ?></p>
            <?php endif; ?>
            <?php if (isset($error_message)): ?>
                <p class="error"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <form action="add_transaction.php" method="post">
                <input type="number" name="amount" placeholder="Amount" required step="0.01">
                <input type="text" name="description" placeholder="Description" required autocomplete="off">
                <select name="category" required>
                    <option value="">Select Category</option>
                    <option value="Food">Food</option>
                    <option value="Transportation">Transportation</option>
                    <option value="Entertainment">Entertainment</option>
                    <option value="Other">Other</option>
                </select>
                <input type="date" name="date" required>
                <select name="type" required>
                    <option value="expense">Expense</option>
                    <option value="income">Income</option>
                </select>
                <button type="submit">Add Transaction</button>
            </form>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
