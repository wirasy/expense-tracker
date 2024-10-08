<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if (delete_expense($id)) {
        header('Location: index.php');
        exit;
    } else {
        echo "Error deleting expense.";
    }
}
