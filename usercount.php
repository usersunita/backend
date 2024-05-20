<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Connection failed: " . $conn->connect_error
    ]));
}

// Query to count the number of records in the guide table
$sql = "SELECT COUNT(id) AS user_count FROM register";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $guideCount = $row["user_count"];
    
    echo json_encode([
        "success" => true,
        "count" => $guideCount
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No user found"
    ]);
}

$conn->close();
?>
