<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
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
    
    // Fetch all users
    $users = get_all_users($conn);
 ?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
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
}
.input-holder label{
    color: #127B8e;
}
    </style>
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php" ?>
    <div class="body">
        <?php include "inc/nav.php" ?>
        <section class="section-1">
            <h4 class="title">Edit Task <a href="tasks.php">Tasks</a></h4>
            <form class="form-1" method="POST" action="app/update-task.php">
                <?php if (isset($_GET['error'])) { ?>
                <div class="danger" role="alert">
                    <?php echo stripcslashes($_GET['error']); ?>
                </div>
                <?php } ?>

                <?php if (isset($_GET['success'])) { ?>
                <div class="success" role="alert">
                    <?php echo stripcslashes($_GET['success']); ?>
                </div>
                <?php } ?>
                
                <div class="input-holder">
                    <label>Title</label>
                    <input type="text" name="title" class="input-1" placeholder="Title" value="<?=$task['title']?>"><br>
                </div>
                <div class="input-holder">
                    <label>Description</label>
                    <textarea name="description" rows="5" class="input-1"><?=$task['description']?></textarea><br>
                </div>
                <div class="input-holder">
                    <label>Snooze</label>
                    <input type="date" name="due_date" class="input-1" placeholder="Snooze" value="<?=$task['due_date']?>"><br>
                </div>

                <div class="input-holder">
                    <label>Assigned to</label>
                    <select name="assigned_to" class="input-1">
                        <option value="0">Select employee</option>
                        <?php if ($users != 0) { 
                            foreach ($users as $user) {
                                $selected = ($task['assigned_to'] == $user['id']) ? 'selected' : '';
                        ?>
                            <option value="<?=$user['id']?>" <?=$selected?>><?=$user['full_name']?></option>
                        <?php } } ?>
                    </select><br>
                </div>
                <input type="text" name="id" value="<?=$task['id']?>" hidden>

                <button class="edit-btn">Update</button>
            </form>
        </section>
    </div>

<script type="text/javascript">
    var active = document.querySelector("#navList li:nth-child(4)");
    active.classList.add("active");
</script>
</body>
</html>
<?php } else { 
   $em = "First login";
   header("Location: login.php?error=$em");
   exit();
}
?>
