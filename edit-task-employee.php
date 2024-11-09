<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "employee") {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";
    
    // Check if 'id' is set in the URL
    if (!isset($_GET['id'])) {
        header("Location: tasks.php");
        exit();
    }

    $id = $_GET['id'];
    // Get task by ID using mysqli
    $task = get_task_by_id($conn, $id);

    // If no task is found, redirect to tasks page
    if ($task == 0) {
        header("Location: tasks.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">

        <style>
        .body{
            background-color: #161616;
        }
        /* General styling */
        .section-1 {
            background-color: black;
            color: #fff;
            padding: 20px;
            border-radius: 8px;
            max-width: 800px;
            margin: auto;
        }
        .title {
            color: #ffffff;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .input-holder label {
            color: #fff;
            font-weight: bold;
            margin-top: 15px;
            padding-bottom: 5px;
            display: block;
        }
        .input-holder input[type="text"],
        .input-holder textarea,
        .input-holder select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #127B8e;
            border-radius: 5px;
            background-color: #f0f0f0;
            font-size: 14px;
            color: #333;
        }
        .form-1 p {
            background-color: #161616;
            margin: 1px;
            padding: 17px 20px;
            font-size: 16px;
            color: #127B8e;
            border-radius: 23px;
        }
        .edit-btn {
            padding: 10px 20px;
            background-color: #127B8e;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            margin-top: 15px;
            display: inline-block;
            text-align: center;
        }
        .edit-btn:hover {
            background-color: #0e5e75;
        }
        .back-link {
            color: #127B8e;
            text-decoration: none;
            font-size: 14px;
            margin-top: 15px;
            display: inline-block;
        }
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php"; ?>
    <div class="body">
        <?php include "inc/nav.php"; ?>
        <section class="section-1">
            <h4 class="title">Edit Task <a href="my_task.php">Tasks</a></h4>

            <!-- Error or Success message display -->
            <?php if (isset($_GET['error'])) { ?>
                <div class="danger" role="alert">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php } ?>

            <?php if (isset($_GET['success'])) { ?>
                <div class="success" role="alert">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php } ?>

            <!-- Task details form -->
            <form class="form-1" method="POST" action="app/update-task-employee.php">
                <div class="input-holder">
                    <label><b>Title: </b></label>
                    <p><?php echo htmlspecialchars($task['title']); ?></p>
                </div>
                <div class="input-holder">
                    <label><b>Description: </b></label>
                    <p><?php echo htmlspecialchars($task['description']); ?></p>
                </div><br>

                <div class="input-holder">
                    <label>Status</label>
                    <select name="status" class="input-1">
                        <option value="pending" <?php echo ($task['status'] == "pending") ? "selected" : ""; ?>>pending</option>
                        <option value="in_progress" <?php echo ($task['status'] == "in_progress") ? "selected" : ""; ?>>in_progress</option>
                        <option value="completed" <?php echo ($task['status'] == "completed") ? "selected" : ""; ?>>completed</option>
                    </select><br>
                </div>
                <input type="text" name="id" value="<?php echo htmlspecialchars($task['id']); ?>" hidden>

                <button class="edit-btn">Update</button>
            </form>
        </section>
    </div>

    <script type="text/javascript">
        var active = document.querySelector("#navList li:nth-child(2)");
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
?>
