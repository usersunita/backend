<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept");
header("Content-Type: application/json");


$conn = new mysqli("localhost", "root", "", "project");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT guide_id, AVG(rating) as average_rating, COUNT(*) as reviews_count FROM review GROUP BY guide_id";
$result = $conn->query($sql);

$feedbackData = array();
while($row = $result->fetch_assoc()) {
    $feedbackData[] = $row;
}

echo json_encode($feedbackData);
$conn->close();
?>
