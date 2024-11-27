<?php

session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "You must be logged in to access this page.";
    header('Location: auth/login.php');
    exit;
}
require_once 'includes/db.php';
require_once 'includes/functions.php';

$total_income = get_total_income();
$total_expenses = get_total_expenses();
$balance = get_balance();
$recent_transactions = get_recent_transactions(10);
$total_transactions = get_total_transactions();

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
                <div class="summary-box total-transactions">
                    <i class="bi bi-list-ul"></i>
                    <h2>Total Transactions</h2>
                    <p><?php echo $total_transactions; ?></p>
                </div>
            </div>
            <div class="chart-container">
            <div class="transaction-chart-box">
            <h2>Recent Transactions</h2>
            <canvas id="transactionChart"></canvas>
            </div>
            <div class="balance-chart-box">
            <h2>Balance Overview</h2>
            <canvas id="balanceChart"></canvas>
    </div>
</div>
        </div>
    </div>
    <script>
       // Transaction Chart
        const transactionCtx = document.getElementById('transactionChart').getContext('2d');
        const transactionChart = new Chart(transactionCtx, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_reverse($dates)); ?>,
                datasets: [{
                    label: 'Transaction Amount',
                    data: <?php echo json_encode(array_reverse($amounts)); ?>,
                    backgroundColor: function(context) {
                        const value = context.dataset.data[context.dataIndex];
                        return value < 0 ? 'rgba(231, 76, 60, 0.8)' : 'rgba(46, 204, 113, 0.8)';
                    },
                    borderColor: function(context) {
                        const value = context.dataset.data[context.dataIndex];
                        return value < 0 ? 'rgba(231, 76, 60, 1)' : 'rgba(46, 204, 113, 1)';
                    },
                    borderWidth: 1,
                    barThickness: 20
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                     }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
        //Chart Balance
        const balanceCtx = document.getElementById('balanceChart').getContext('2d');
        const balanceChart = new Chart(balanceCtx, {
            type: 'doughnut',
            data: {
                labels: ['Income', 'Expenses'],
                datasets: [{
                    data: [<?php echo $total_income; ?>, <?php echo $total_expenses; ?>],
                    backgroundColor: [
                        'rgba(46, 204, 113, 0.8)',
                        'rgba(231, 76, 60, 0.8)'
                    ],
                    borderColor: [
                        'rgba(46, 204, 113, 1)',
                        'rgba(231, 76, 60, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    title: {
                        display: true,
                    }
                }
            }
        });
    </script>
    <script src="js/script.js"></script>
</body>
</html>
