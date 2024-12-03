<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

session_start();

if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "You must be logged in to access this page.";
    header('Location: login.php');
    exit;
}

$transaction = null;
$success_message = '';
$error_message = '';

if (isset($_GET['id'])) {
    $transaction = get_transaction_by_id($_GET['id']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $date = $_POST['date'];
    $type = $_POST['type'];

    if (update_transaction($id, $amount, $description, $category, $date, $type)) {
        $success_message = "Transaction updated successfully.";
        $transaction = get_transaction_by_id($id);
    } else {
        $error_message = "Error updating transaction.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaction - We Tracker</title>
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
                    <h1>Edit Transaction</h1>
                    <?php if ($success_message): ?>
                        <p class="success"><?php echo $success_message; ?></p>
                    <?php endif; ?>
                    <?php if ($error_message): ?>
                        <p class="error"><?php echo $error_message; ?></p>
                    <?php endif; ?>
                    
                    <?php if ($transaction): ?>
                    <form action="edit_transaction.php" method="post" class="transaction-form">
                        <input type="hidden" name="id" value="<?php echo $transaction['id']; ?>">
                        
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" id="amount" name="amount" value="<?php echo $transaction['amount']; ?>" required step="0.01">
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" id="description" name="description" value="<?php echo $transaction['description']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <select id="category" name="category" required>
                                <option value="Food" <?php echo $transaction['category'] == 'Food' ? 'selected' : ''; ?>>Food</option>
                                <option value="Transportation" <?php echo $transaction['category'] == 'Transportation' ? 'selected' : ''; ?>>Transportation</option>
                                <option value="Entertainment" <?php echo $transaction['category'] == 'Entertainment' ? 'selected' : ''; ?>>Entertainment</option>
                                <option value="Other" <?php echo $transaction['category'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="date">Date</label>
                            <input type="date" id="date" name="date" value="<?php echo $transaction['date']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="type">Type</label>
                            <select id="type" name="type" required>
                                <option value="expense" <?php echo $transaction['type'] == 'expense' ? 'selected' : ''; ?>>Expense</option>
                                <option value="income" <?php echo $transaction['type'] == 'income' ? 'selected' : ''; ?>>Income</option>
                            </select>
                        </div>

                        <button type="submit" class="submit-btn">Update Transaction</button>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>


