<?php
function get_expenses() {
    global $conn;
    $user_id = $_SESSION['user_id']; // Assuming the user_id is stored in the session
    $sql = "SELECT * FROM expenses WHERE user_id = ? ORDER BY date DESC";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function add_transaction($amount, $description, $category, $date, $type) {
    global $conn;
    $user_id = $_SESSION['user_id']; // Assuming the user_id is stored in the session
    $sql = "INSERT INTO expenses (user_id, amount, description, category, date, type) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "idssss", $user_id, $amount, $description, $category, $date, $type);
    return mysqli_stmt_execute($stmt);
}

function get_total_income() {
    global $conn;
    $user_id = $_SESSION['user_id']; // Assuming the user_id is stored in the session
    $sql = "SELECT SUM(amount) as total FROM expenses WHERE user_id = ? AND type = 'income'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}

function get_total_expenses() {
    global $conn;
    $user_id = $_SESSION['user_id']; // Assuming the user_id is stored in the session
    $sql = "SELECT SUM(amount) as total FROM expenses WHERE user_id = ? AND type = 'expense'";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}

function get_recent_transactions($limit = 5) {
    global $conn;
    $user_id = $_SESSION['user_id']; // Assuming the user_id is stored in the session
    $sql = "SELECT * FROM expenses WHERE user_id = ? ORDER BY date DESC LIMIT ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function delete_expense($id) {
    global $conn;
    $user_id = $_SESSION['user_id']; // Assuming the user_id is stored in the session
    $sql = "DELETE FROM expenses WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
    return mysqli_stmt_execute($stmt);
}

function get_transaction_by_id($id) {
    global $conn;
    $user_id = $_SESSION['user_id'];
    
    $sql = "SELECT * FROM expenses WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id, $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    return mysqli_fetch_assoc($result);
}

function update_transaction($id, $amount, $description, $category, $date, $type) {
    global $conn;
    $user_id = $_SESSION['user_id'];
    
    $sql = "UPDATE expenses SET amount = ?, description = ?, category = ?, date = ?, type = ? 
            WHERE id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "dssssii", $amount, $description, $category, $date, $type, $id, $user_id);
    
    return mysqli_stmt_execute($stmt);
}


function get_total_transactions() {
    global $conn;
    $user_id = $_SESSION['user_id']; // Assuming the user_id is stored in the session
    $sql = "SELECT COUNT(*) as total FROM expenses WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}

function get_balance() {
$income = get_total_income();
$expenses = get_total_expenses();
return $income - $expenses;
}

function login($username, $password) {
    global $conn;
    
    // Prepare the SQL statement
    $sql = "SELECT id, username, password FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        // Bind the username parameter
        mysqli_stmt_bind_param($stmt, "s", $username);
        
        // Execute the statement
        mysqli_stmt_execute($stmt);
        
        // Get the result
        $result = mysqli_stmt_get_result($stmt);
        
        if ($row = mysqli_fetch_assoc($result)) {
            // Verify the password
            if (password_verify($password, $row['password'])) {
                // Password is correct, set session variables
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                return true;
            }
        }
        
        // Close the statement
        mysqli_stmt_close($stmt);
    }
    
    // Login failed
    return false;
}

function register($username, $password) {
    global $conn;
    
    // Check if the username already exists
    $check_sql = "SELECT id FROM users WHERE username = ?";
    $check_stmt = mysqli_prepare($conn, $check_sql);
    
    if ($check_stmt) {
        mysqli_stmt_bind_param($check_stmt, "s", $username);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);
        
        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            // Username already exists
            mysqli_stmt_close($check_stmt);
            return false;
        }
        
        mysqli_stmt_close($check_stmt);
    }
    
    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare the SQL statement
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    
    if ($stmt) {
        // Bind the parameters
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
        
        // Execute the statement
        $result = mysqli_stmt_execute($stmt);
        
        // Close the statement
        mysqli_stmt_close($stmt);
        
        return $result;
    }
    
    return false;
}
