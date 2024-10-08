<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$expenses = get_expenses();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container">
        <h1>Expense Tracker</h1>
        <div class="add-expense">
            <h2>Add New Expense</h2>
            <form action="add_expense.php" method="post">
                <input type="number" name="amount" placeholder="Amount" required>
                <input type="text" name="description" placeholder="Description" required>
                <select name="category" required>
                    <option value="">Select Category</option>
                    <option value="Food">Food</option>
                    <option value="Transportation">Transportation</option>
                    <option value="Entertainment">Entertainment</option>
                    <option value="Other">Other</option>
                </select>
                <input type="date" name="date" required>
                <button type="submit">Add Expense</button>
            </form>
        </div>
        <div class="expense-list">
            <h2>Expense List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($expenses as $expense): ?>
                    <tr>
                        <td><?php echo $expense['date']; ?></td>
                        <td>$<?php echo number_format($expense['amount'], 2); ?></td>
                        <td><?php echo $expense['description']; ?></td>
                        <td><?php echo $expense['category']; ?></td>
                        <td>
                            <a href="delete_expense.php?id=<?php echo $expense['id']; ?>" class="delete-btn">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="js/script.js"></script>
</body>
</html>
