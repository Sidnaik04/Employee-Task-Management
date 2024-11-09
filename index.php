<?php 
session_start();

// Include necessary files
include "DB_connection.php";
include "app/Model/Task.php";
include "app/Model/User.php";

// Check if the user is logged in
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

    // Initialize Dashboard Variables
    if ($_SESSION['role'] == "admin") {
        // Admin Dashboard Data
        $dashboardData = get_admin_dashboard_data($conn);
    } else {
        // Employee Dashboard Data
        $dashboardData = get_employee_dashboard_data($conn, $_SESSION['id']);
    }

    // Include header and navigation
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
       .section-1 {
    background-color: #161616;
    display: flex;
    justify-content: center; /* Horizontally center the dashboard */
    align-items: start; /* Vertically center the dashboard */
    min-height: 100vh; /* Ensure it takes the full height of the screen */
}

.dashboard {
    display: grid; /* Use grid layout to create a neat, responsive grid */
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); /* Create responsive grid items */
    gap: 20px; /* Space between the dashboard items */
    max-width: 1200px; /* Set a max width for the dashboard */
    width: 100%; /* Allow it to take the full width of the screen */
}

.dashboard-item {
    background-color: #12728e; /* White background for each item */
    padding-top: 74px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    text-align: center; /* Center the text */
    height: 212px;
    width: 187px;
}

.dashboard-item i {
    font-size: 30px; /* Increase icon size */
    margin-bottom: 10px; /* Space between the icon and text */
}

.dashboard-item span {
    font-size: 18px;
    font-weight: bold;
    

}

    </style>

</head>
<body>
    <?php include "inc/header.php"?>

    <input type="checkbox" id="checkbox">
    <div class="body">
    <?php include "inc/nav.php" ?>

        <section class="section-1">
            <div class="dashboard">
                <?php foreach ($dashboardData as $item): ?>
                    <div class="dashboard-item">
                        <i class="fa <?php echo $item['icon']; ?>"></i>
                        <span><?php echo $item['count']; ?> <?php echo $item['label']; ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </div>

    <script type="text/javascript">
        var active = document.querySelector("#navList li:nth-child(1)");
        active.classList.add("active");
    </script>
</body>
</html>

<?php 
} else { 
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
}

// Functions to Fetch Dashboard Data

function get_admin_dashboard_data($conn) {
    return [
        ['icon' => 'fa-users', 'count' => count_users($conn), 'label' => 'Employee'],
        ['icon' => 'fa-tasks', 'count' => count_tasks($conn), 'label' => 'All Tasks'],
        ['icon' => 'fa-window-close-o', 'count' => count_tasks_overdue($conn), 'label' => 'Overdue'],
        ['icon' => 'fa-clock-o', 'count' => count_tasks_NoDeadline($conn), 'label' => 'No Deadline'],
        ['icon' => 'fa-exclamation-triangle', 'count' => count_tasks_due_today($conn), 'label' => 'Due Today'],
        ['icon' => 'fa-bell', 'count' => count_tasks_overdue($conn), 'label' => 'Over Due'],
        ['icon' => 'fa-square-o', 'count' => count_pending_tasks($conn), 'label' => 'Pending'],
        ['icon' => 'fa-spinner', 'count' => count_in_progress_tasks($conn), 'label' => 'In progress'],
        ['icon' => 'fa-check-square-o', 'count' => count_completed_tasks($conn), 'label' => 'Completed']
    ];
}

function get_employee_dashboard_data($conn, $user_id) {
    return [
        ['icon' => 'fa-tasks', 'count' => count_my_tasks($conn, $user_id), 'label' => 'My Tasks'],
        ['icon' => 'fa-window-close-o', 'count' => count_my_tasks_overdue($conn, $user_id), 'label' => 'Overdue'],
        ['icon' => 'fa-clock-o', 'count' => count_my_tasks_NoDeadline($conn, $user_id), 'label' => 'No Deadline'],
        ['icon' => 'fa-square-o', 'count' => count_my_pending_tasks($conn, $user_id), 'label' => 'Pending'],
        ['icon' => 'fa-spinner', 'count' => count_my_in_progress_tasks($conn, $user_id), 'label' => 'In progress'],
        ['icon' => 'fa-check-square-o', 'count' => count_my_completed_tasks($conn, $user_id), 'label' => 'Completed']
    ];
}
?>
