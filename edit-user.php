<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";

    if (!isset($_GET['id'])) {
        header("Location: user.php");
        exit();
    }
    $id = $_GET['id'];
    $user = get_user_by_id($conn, $id);

    if ($user == 0) {
        header("Location: user.php");
        exit();
    }

    // Fetch departments for the dropdown
    $sql = "SELECT * FROM department";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
    	.section-1 {
        	background-color: #161616;
		}
        .section-1 .title {
			color:white;
		}
		.main-table{
			color:#127B8e;
		}
		.main-table th {
			background-color: #000000;
		}
		.input-holder lable{
			color: #127B8e;
		}

        label{
            color: #fff;
        }
    </style>
</head>
<body>
    <input type="checkbox" id="checkbox">
    <?php include "inc/header.php" ?>
    <div class="body">
        <?php include "inc/nav.php" ?>
        <section class="section-1">
            <h4 class="title">Edit Users <a href="user.php">Users</a></h4>
            <form class="form-1" method="POST" action="app/update-user.php">
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
                    <label >Full Name</label>
                    <input type="text" name="full_name" class="input-1" placeholder="Full Name" value="<?=$user['full_name']?>"><br>
                </div>
                <div class="input-holder">
                    <label>Username</label>
                    <input type="text" name="user_name" value="<?=$user['username']?>" class="input-1" placeholder="Username"><br>
                </div>
                <div class="input-holder">
                    <label>Password</label>
                    <input type="password" name="password" class="input-1" placeholder="Enter new password (leave blank to keep current password)">
                </div>


                <!-- Department Dropdown -->
                <div class="input-holder">
                    <label>Department</label>
                    <select name="department_id" class="input-1">
                        <option value="">Select Department</option>
                        <?php while ($department = $result->fetch_assoc()) { ?>
                            <option value="<?= $department['id'] ?>" <?= isset($user['department_id']) && $department['id'] == $user['department_id'] ? 'selected' : '' ?>>
                                <?= $department['name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <input type="text" name="id" value="<?=$user['id']?>" hidden>
                <button class="edit-btn" style="margin-top: 20px;">Update</button>
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
