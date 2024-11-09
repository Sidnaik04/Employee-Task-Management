<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";


    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $sql = "SELECT * FROM tasks WHERE assigned_to = '" . $_SESSION['id'] . "'";
    if ($search) {
        $sql .= " AND status = '$search'";
    }
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Tasks</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* (Include your styling code here as provided above) */
        .section-1 {
            background-color: #161616;
		}
        
        .section-1 .title {
            color:#fff;
        }
        .input-holder lable{
            color:#127B8e;
        }

        /* Styling for the search bar */
        .search-form {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 20px;
        }

        .search-form input[type="text"] {
            width: 250px;
            padding: 8px;
            margin-right: 10px;
            border: 2px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .search-form button {
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        .search-form button:hover {
            background-color: #0056b3;
        }

        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .main-table th, .main-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: left;
        }

        .main-table th {
            background-color: black;
            color:#127B8e;
        }

        .main-table td {
            color:#127B8e;
        }

        .edit-btn {
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
            background-color: #28a745;
            color: white;
        }

        .edit-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php" ?>
    <div class="body">
        <?php include "inc/nav.php" ?>
        <section class="section-1">
            <h4 class="title">My Tasks</h4>

            <!-- Status Filter -->
            <form method="GET" action="my_task.php" class="search-form">
                <select name="search" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="pending" <?= $search == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="in_progress" <?= $search == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                    <option value="completed" <?= $search == 'completed' ? 'selected' : '' ?>>Completed</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>

            <!-- Success Message -->
            <?php if (isset($_GET['success'])) { ?>
                <div class="success" role="alert">
                    <?php echo stripcslashes($_GET['success']); ?>
                </div>
            <?php } ?>

            <!-- Task Table -->
            <?php if ($result && $result->num_rows > 0) { ?>
                <table class="main-table">
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Action</th>
                    </tr>
                    <?php $i = 0; while ($task = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= ++$i ?></td>
                            <td><?= htmlspecialchars($task['title']) ?></td>
                            <td><?= htmlspecialchars($task['description']) ?></td>
                            <td><?= htmlspecialchars($task['status']) ?></td>
                            <td><?= htmlspecialchars($task['due_date']) ?></td>
                            <td>
                                <a href="edit-task-employee.php?id=<?= $task['id'] ?>" class="edit-btn">Edit</a>
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            <?php } else { ?>
                <h3 style="color:#fff">No tasks available.</h3>
            <?php } ?>
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
