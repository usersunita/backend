<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$servername = "localhost";
$username = "root";
$password = "";
$database = "project";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}
$sql = "SELECT * FROM review ORDER BY id";

$result = $conn->query($sql);

$inquiries = [];

if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        $inquiries[] = $row;
    }
    echo json_encode($inquiries);
} else {
    echo json_encode($inquiries);
}
$conn->close();
?>
