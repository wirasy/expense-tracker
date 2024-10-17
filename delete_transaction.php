<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error_message'] = "You must be logged in to access this page.";
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (delete_expense($id)) {
        header('Location: transaction_history.php');
        exit;
    } else {
        echo "Error deleting expense.";
    }
}
