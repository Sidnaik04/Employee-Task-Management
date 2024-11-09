<?php 
session_start();

// Check if user is logged in and is an admin
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";
    
    // Check if 'id' is passed in the URL
    if (!isset($_GET['id'])) {
        header("Location: user.php");
        exit();
    }

    $id = $_GET['id'];
    // Get user details by ID
    $user = get_user_by_id($conn, $id);

    // If user doesn't exist, redirect to user page
    if ($user == 0) {
        header("Location: user.php");
        exit();
    }

    // Delete the user (using the array with ID and role)
    $data = array($id, "employee");
    delete_user($conn, $data);

    // Success message and redirection
    $sm = "Deleted Successfully";
    header("Location: user.php?success=" . urlencode($sm));
    exit();
} else { 
    // If the user is not logged in or not an admin, redirect to login page
    $em = "First login";
    header("Location: login.php?error=" . urlencode($em));
    exit();
}
?>
