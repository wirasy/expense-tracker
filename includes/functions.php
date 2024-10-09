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

