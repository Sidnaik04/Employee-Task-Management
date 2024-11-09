<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";


    $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $sql = "SELECT users.id, users.full_name, users.username, users.role, department.name as department_name
        FROM users
        LEFT JOIN department ON users.department_id = department.id";

    if ($search) {
        $sql .= " WHERE full_name LIKE '%$search%' OR username LIKE '%$search%'";
    }
    $result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <style>
           .section-1 {
            background-color: #161616;}
            .section-1 .title {
   color:white;
}
.section-1 .title a{
	text-decoration: none;
	display: inline-block;
    padding-left: 10px;
	border: none;
	background: #007fff;
	padding: 10px 15px;
	color: #fff;
	font-size: 16px;
	border-radius: 5px;
	cursor: pointer;
	outline: none;
	transition: background 1s;
	box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2), 0 6px 20px 0 rgba(0,0,0,0.19);
}

.section-1 .title a:hover{
    text-decoration: none;
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
            background-color: #f4f4f4;
        }

        .edit-btn, .delete-btn {
            padding: 5px 10px;
            border-radius: 4px;
            text-decoration: none;
        }

        .edit-btn {
            background-color: #28a745;
            color: white;
        }

        .delete-btn {
            background-color: #dc3545;
            color: white;
        }

        .edit-btn:hover {
            background-color: #218838;
        }

        .delete-btn:hover {
            background-color: #c82333;
        }

        .title a {
            color: #007bff;
            text-decoration: none;
        }

        .title a:hover {
            text-decoration: underline;
        }
        .main-table{
            color:#127B8e;
        }
        .main-table th {
    background-color: #000000;
}
    </style>
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php" ?>
    
    <div class="body">
        <?php include "inc/nav.php" ?>

        <section class="section-1">
            <h4 class="title">Manage Users <a href="add-user.php">Add User</a></h4>

            <!-- Search Bar -->
            <form method="GET" action="user.php" class="search-form">
                <input type="text" name="search" placeholder="Search by name or username" value="<?= htmlspecialchars($search) ?>" class="form-control">
                <button type="submit" class="btn btn-primary">Search</button>
            </form>

            <!-- Success Message -->
            <?php if (isset($_GET['success'])) { ?>
                <div class="success" role="alert">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                </div>
            <?php } ?>

            <!-- User Table -->
            <?php if ($result && $result->num_rows > 0) { ?>
                <table class="main-table">
    <tr>
        <th>#</th>
        <th>Full Name</th>
        <th>Username</th>
        <th>Role</th>
        <th>Department</th> <!-- Add this column -->
        <th>Action</th>
    </tr>
    <?php $i = 0; while ($user = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= ++$i ?></td>
            <td><?= htmlspecialchars($user['full_name']) ?></td>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['role']) ?></td>
            <td><?= htmlspecialchars($user['department_name']) ?></td> <!-- Display department name -->
            <td>
                <a href="edit-user.php?id=<?= $user['id'] ?>" class="edit-btn">Edit</a>
                <a href="delete-user.php?id=<?= $user['id'] ?>" class="delete-btn">Delete</a>
            </td>
        </tr>
    <?php } ?>
</table>

            <?php } else { ?>
                <h3 style="color: #fff;">No users found.</h3>
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
    // Redirect to login if not an admin
    $em = "Please log in first.";
    header("Location: login.php?error=" . urlencode($em));
    exit();
}
?>
