<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";
    
    // Default task text
    $text = "All Tasks";

    // Determine task filter criteria based on URL parameter 'due_date'
    if (isset($_GET['due_date'])) {
        switch ($_GET['due_date']) {
            case "Due Today":
                $text = "Due Today";
                $tasks = get_all_tasks_due_today($conn);
                $num_task = count_tasks_due_today($conn);
                break;
            case "Overdue":
                $text = "Overdue";
                $tasks = get_all_tasks_overdue($conn);
                $num_task = count_tasks_overdue($conn);
                break;
            case "No Deadline":
                $text = "No Deadline";
                $tasks = get_all_tasks_NoDeadline($conn);
                $num_task = count_tasks_NoDeadline($conn);
                break;
            default:
                $tasks = get_all_tasks($conn);
                $num_task = count_tasks($conn);
                break;
        }
    } else {
        $tasks = get_all_tasks($conn);
        $num_task = count_tasks($conn);
    }

    // Fetch all users for displaying assigned tasks
    $users = get_all_users($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Tasks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
          .section-1 {
            background-color: #161616;}
            .section-1 .title {
   color:white;
}
.main-table{
            color:#127B8e;
        }
        .main-table th {
    background-color: #000000;
}.title-2{
    color: white;
}

    </style>
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php"; ?>
    
    <div class="body">
        <?php include "inc/nav.php"; ?>

        <section class="section-1">
            <h4 class="title-2">
                <a href="create_task.php" class="btn">Create Task</a>
                <a href="tasks.php?due_date=Due Today">Due Today</a>
                <a href="tasks.php?due_date=Overdue">Overdue</a>
                <a href="tasks.php">All Tasks</a>
            </h4>

            <!-- Display current filter text and task count -->
            <h4 class="title-2"><?= htmlspecialchars($text) ?> (<?= htmlspecialchars($num_task) ?>)</h4>

            <!-- Success message -->
            <?php if (isset($_GET['success'])) { ?>
                <div class="success" role="alert">
                    <?= htmlspecialchars($_GET['success']); ?>
                </div>
            <?php } ?>

            <!-- Task table -->
            <?php if ($tasks != 0) { ?>
                <table class="main-table">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Assigned To</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    <?php $i = 0; foreach ($tasks as $task) { ?>
                        <tr>
                            <td><?= ++$i ?></td>
                            <td><?= htmlspecialchars($task['title']) ?></td>
                            <td><?= htmlspecialchars($task['description']) ?></td>
                            <td><?= htmlspecialchars($task['assigned_user'] ?? 'Admin') ?></td>
                            <td><?= empty($task['due_date']) ? "No Deadline" : htmlspecialchars($task['due_date']) ?></td>
                            <td><?= htmlspecialchars($task['status']) ?></td>
                            <td>
                                <a href="edit-task.php?id=<?= $task['id'] ?>" class="edit-btn">Edit</a>
                                <a href="delete-task.php?id=<?= $task['id'] ?>" class="delete-btn">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>

                </table>
            <?php } else { ?>
                <h3>No tasks available.</h3>
            <?php } ?>
        </section>
    </div>

    <script type="text/javascript">
        var active = document.querySelector("#navList li:nth-child(4)");
        active.classList.add("active");
    </script>
</body>
</html>

<?php
} else {
    // Redirect to login if not logged in or not an admin
    $em = "Please log in first.";
    header("Location: login.php?error=" . urlencode($em));
    exit();
}
?>
