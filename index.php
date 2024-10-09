<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

$total_income = get_total_income();
$total_expenses = get_total_expenses();
$balance = get_balance();
$recent_transactions = get_recent_transactions(10);

// Prepare data for transaction chart
$dates = [];
$amounts = [];
foreach ($recent_transactions as $transaction) {
    $dates[] = $transaction['date'];
    $amounts[] = $transaction['type'] == 'income' ? $transaction['amount'] : -$transaction['amount'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - W-Tracker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="container">
        <?php include 'includes/sidebar.php'; ?>
        <div class="content">
            <h1>Dashboard</h1>
            <div class="dashboard-summary">
                <div class="summary-box income">
                    <i class="bi bi-piggy-bank"></i>
                    <h2>Total Income</h2>
                    <p>RP. <?php echo number_format($total_income, 3); ?></p>
                </div>
                <div class="summary-box expenses">
                    <i class="bi bi-cash-stack"></i>
                    <h2>Total Expenses</h2>
                    <p>Rp. <?php echo number_format($total_expenses, 3); ?></p>
                </div>
                <div class="summary-box balance">
                    <i class="bi bi-wallet2"></i>
                    <h2>Balance</h2>
                    <p>Rp. <?php echo number_format($balance, 3); ?></p>
                </div>
            </div>
            <div class="recent-transactions">
                <h2>Recent Transactions</h2>
                <canvas id="transactionChart"></canvas>
            </div>
        </div>
    </div>
    <script>
        // Chart
        var ctx = document.getElementById('transactionChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_reverse($dates)); ?>,
                datasets: [{
                    label: 'Transaction Amount',
                    data: <?php echo json_encode(array_reverse($amounts)); ?>,
                    backgroundColor: function(context) {
                        var index = context.dataIndex;
                        var value = context.dataset.data[index];
                        return value < 0 ? 'rgba(255, 99, 132, 0.5)' : 'rgba(75, 192, 192, 0.5)';
                    },
                    borderColor: function(context) {
                        var index = context.dataIndex;
                        var value = context.dataset.data[index];
                        return value < 0 ? 'rgb(255, 99, 132)' : 'rgb(75, 192, 192)';
                    },
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script src="js/script.js"></script>
</body>
</html>

