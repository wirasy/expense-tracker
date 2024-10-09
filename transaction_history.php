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
    <title>Transaction History - W-Tracker</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>
    <div class="container">
        <?php include 'includes/sidebar.php'; ?>
        <div class="content">
            <h1>Transaction History</h1>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($expenses as $expense): ?>
                    <tr class="<?php echo $expense['type']; ?>">
                        <td><?php echo $expense['date']; ?></td>
                        <td>Rp. <?php echo number_format($expense['amount'], 3); ?></td>
                        <td><?php echo $expense['description']; ?></td>
                        <td><?php echo $expense['category']; ?></td>
                        <td><?php echo ucfirst($expense['type']); ?></td>
                        <td>
                            <a href="delete_transaction.php?id=<?php echo $expense['id']; ?>" class="delete-btn">Delete</a>
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
