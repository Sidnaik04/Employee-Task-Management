<?php 
session_start();

// Check if the user is logged in and has admin privileges
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/Task.php";
    
    // Ensure that 'id' is passed in the URL
    if (!isset($_GET['id'])) {
        header("Location: tasks.php");
        exit();
    }

    $id = $_GET['id'];
    // Retrieve task details by ID
    $task = get_task_by_id($conn, $id);

    // If the task doesn't exist, redirect to tasks page
    if ($task == 0) {
        header("Location: tasks.php");
        exit();
    }

    // Prepare data to delete the task
    $data = array($id);
    delete_task($conn, $data);

    // Success message and redirection
    $sm = "Deleted Successfully";
    header("Location: tasks.php?success=" . urlencode($sm));
    exit();

} else { 
    // If the user is not logged in or is not an admin, redirect to login page
    $em = "First login";
    header("Location: login.php?error=" . urlencode($em));
    exit();
}
?>
