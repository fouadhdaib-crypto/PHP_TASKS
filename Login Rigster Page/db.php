
<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "user_data_base";

// Connect PHP to MySQL
$conn = new mysqli(
    $host,
    $username,
    $password,
    $database
);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");


?>
