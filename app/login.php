<?php 
session_start();

if (isset($_POST['user_name'], $_POST['password'])) {
    include "../DB_connection.php";

    // Sanitize user input
    function validate_input($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    // Get and validate user input
    $user_name = validate_input($_POST['user_name']);
    $password = validate_input($_POST['password']);

    if (empty($user_name)) {
        redirect_with_error("User name is required");
    } 

    if (empty($password)) {
        redirect_with_error("Password is required");
    }

    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_name);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) { // Use num_rows for mysqli
        // Correctly bind columns from the result set
        $stmt->bind_result($id, $usernameDb, $passwordDb, $role); // Bind the result columns to PHP variables
        $stmt->fetch(); // Fetch the result

        if (password_verify($password, $passwordDb)) {
            // Valid login: set session variables
            $_SESSION['role'] = $role;
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $usernameDb;

            // Redirect based on role
            if ($role === 'admin' || $role === 'employee') {
                header("Location: ../index.php");
                exit();
            } else {
                redirect_with_error("Unknown role or error occurred");
            }
        } else {
            redirect_with_error("Incorrect username or password");
        }
    } else {
        redirect_with_error("Incorrect username or password");
    }

    $stmt->close(); // Close the prepared statement
} else {
    redirect_with_error("Unknown error occurred");
}

// Helper function for redirection with error message
function redirect_with_error($error_message) {
    header("Location: ../login.php?error=" . urlencode($error_message));
    exit();
}
?>
