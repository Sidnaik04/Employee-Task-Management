<?php 
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] == "admin") {
    include "../DB_connection.php";

    if (isset($_POST['id'], $_POST['full_name'], $_POST['user_name'], $_POST['department_id'])) {
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['user_name'];
        $department_id = $_POST['department_id'];
        
        // Check if a new password is provided
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $sql = "UPDATE users SET full_name = ?, username = ?, password = ?, department_id = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssii", $full_name, $username, $password, $department_id, $id);
        } else {
            // If no new password is provided, skip the password update
            $sql = "UPDATE users SET full_name = ?, username = ?, department_id = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssii", $full_name, $username, $department_id, $id);
        }

        if ($stmt->execute()) {
            header("Location: ../edit-user.php?id=$id&success=User updated successfully");
            exit();
        } else {
            header("Location: ../edit-user.php?id=$id&error=Failed to update user");
            exit();
        }
    } else {
        header("Location: ../user.php?error=Invalid input");
        exit();
    }
} else {
    header("Location: ../login.php?error=Unauthorized access");
    exit();
}
