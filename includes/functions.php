<?php
function get_expenses() {
    global $conn;
    $sql = "SELECT * FROM expenses ORDER BY date DESC";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function add_expense($amount, $description, $category, $date) {
    global $conn;
    $sql = "INSERT INTO expenses (amount, description, category, date) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "dsss", $amount, $description, $category, $date);
    return mysqli_stmt_execute($stmt);
}

function delete_expense($id) {
    global $conn;
    $sql = "DELETE FROM expenses WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    return mysqli_stmt_execute($stmt);
}
