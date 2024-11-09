<?php  
$sName = "localhost";
$uName = "root";
$pass  = "";
$db_name = "final_project";

$conn = new mysqli($sName, $uName, $pass, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
