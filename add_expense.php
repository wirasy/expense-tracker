<?php
require_once 'includes/db.php';
require_once 'includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $date = $_POST['date'];

    if (add_expense($amount, $description, $category, $date)) {
        header('Location: index.php');
        exit;
    } else {
        echo "Error adding expense.";
    }
}
