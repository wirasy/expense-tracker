<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (delete_expense($id)) {
        header('Location: transaction_history.php');
        exit;
    } else {
        echo "Error deleting expense.";
    }
}
