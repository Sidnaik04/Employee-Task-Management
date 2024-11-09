<?php
session_start();

// Check if the user is logged in and has the 'employee' role
if (isset($_SESSION['role'], $_SESSION['id']) && $_SESSION['role'] === "employee") {
    include "DB_connection.php";
    include "app/Model/User.php";
    
    // Fetch user data based on session ID
    $user = get_user_by_id($conn, $_SESSION['id']);
    if (!$user) {
        // If no userS found, redirect to login
        header("Location: login.php?error=" . urlencode('User not found.'));
        exit();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
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
            <h4 class="title">Profile <a href="edit_profile.php">Edit Profile</a></h4>
            
            <!-- User Profile Information -->
            <table class="main-table" style="max-width: 300px;">
                <tr>
                    <td><strong>Full Name</strong></td>
                    <td><?= htmlspecialchars($user['full_name']) ?></td>
                </tr>
                <tr>
                    <td><strong>Username</strong></td>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                </tr>
                <tr>
                    <td><strong>Joined At</strong></td>
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                </tr>
                <tr>
                    <td><strong>Department</strong></td>
                    <td><?= htmlspecialchars($user['department_name']) ?></td>
                </tr>
            </table>

        </section>
    </div>

    <script type="text/javascript">
        var active = document.querySelector("#navList li:nth-child(3)");
        active.classList.add("active");
    </script>
</body>
</html>
<?php
} else {
    // Redirect to login if the session is invalid or the role is not 'employee'
    $em = "Please log in first.";
    header("Location: login.php?error=" . urlencode($em));
    exit();
}
?>
