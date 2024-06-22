<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode([
        "success" => false,
        "message" => "Connection failed: " . $conn->connect_error
    ]));
}

$sql = "SELECT COUNT(id) AS review_count FROM review";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $reviewCount = $row["review_count"];
    
    echo json_encode([
        "success" => true,
        "count" => $reviewCount
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No user found"
    ]);
}

$conn->close();
?>
