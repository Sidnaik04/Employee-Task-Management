<?php 

function get_all_users($conn) {
    $sql = "SELECT users.id, users.full_name, users.username, users.role, department.name AS department_name 
            FROM users 
            LEFT JOIN department ON users.department_id = department.id 
            WHERE role = ?";
    $stmt = $conn->prepare($sql);
    $role = "employee";  
    $stmt->bind_param("s", $role);  
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $users = $result->fetch_all(MYSQLI_ASSOC);  
    } else {
        $users = 0;
    }

    return $users;
}


function insert_user($conn, $data){
    $password = password_hash($data[2], PASSWORD_DEFAULT);  
    $sql = "INSERT INTO users (full_name, username, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $data[0], $data[1], $password, $data[3]);
    $stmt->execute();
}


function update_user($conn, $data) {
    $sql = "UPDATE users SET full_name=?, username=?, password=?, role=?, department_id=? WHERE id=? AND role=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssisi", $data[0], $data[1], $data[2], $data[3], $data[6], $data[4], $data[5]);
    $stmt->execute();
}


function delete_user($conn, $data){
    $sql = "DELETE FROM users WHERE id = ? AND role = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $data[0], $data[1]);
    $stmt->execute();
}



function get_user_by_id($conn, $user_id) {
    $sql = "SELECT users.id, users.full_name, users.username, users.created_at, department.name as department_name
            FROM users
            LEFT JOIN department ON users.department_id = department.id
            WHERE users.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}



function update_profile($conn, $data){
    $sql = "UPDATE users SET full_name = ?, password = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $data[0], $data[1], $data[2]);
    $stmt->execute();
}

function count_users($conn){
    $sql = "SELECT id FROM users WHERE role = 'employee'";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $result = $stmt->get_result();
    return $result->num_rows; 
}

