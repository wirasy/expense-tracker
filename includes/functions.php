<?php
function get_expenses() {
    global $conn;
    $sql = "SELECT * FROM expenses ORDER BY date DESC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function add_transaction($amount, $description, $category, $date, $type) {
    global $conn;
    $sql = "INSERT INTO expenses (amount, description, category, date, type) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "dssss", $amount, $description, $category, $date, $type);
    return mysqli_stmt_execute($stmt);
}
function get_total_income() {
    global $conn;
    $sql = "SELECT SUM(amount) as total FROM expenses WHERE type = 'income'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}
function get_balance() {
    $income = get_total_income();
    $expenses = get_total_expenses();
    return $income - $expenses;
}
function delete_expense($id) {
    global $conn;
    $sql = "DELETE FROM expenses WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
}
function get_total_expenses() {
    global $conn;
    $sql = "SELECT SUM(amount) as total FROM expenses WHERE type = 'expense'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}

function get_recent_transactions($limit = 5) {
    global $conn;
    $sql = "SELECT * FROM expenses ORDER BY date DESC LIMIT ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_daily_balance($days = 30) {
    global $conn;
    $sql = "SELECT DATE(date) as date, 
                   SUM(CASE WHEN type = 'income' THEN amount ELSE -amount END) as daily_balance
            FROM expenses
            WHERE date >= DATE_SUB(CURDATE(), INTERVAL ? DAY)
            GROUP BY DATE(date)
            ORDER BY date";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $days);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $daily_balance = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $running_balance = 0;
    $balance_data = [];
    foreach ($daily_balance as $day) {
        $running_balance += $day['daily_balance'];
        $balance_data[] = [
            'date' => $day['date'],
            'balance' => $running_balance
        ];
    }
    return $balance_data;
}
